<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AgenceRepository;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $encoder;
    private $serializer;
    private $pro;
    private $validator;
    private $em;
    private $repoUser;
    private $weuz;
    private $agenRepo;
    public function __construct(
        UserPasswordEncoderInterface $encoder,
        SerializerInterface $serializer,
        ProfilRepository $pro,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        UserRepository $repo,
        Security $weuz,
        AgenceRepository $agenRepo

    )
    {
        $this -> encoder = $encoder;
        $this -> serializer = $serializer;
        $this -> pro = $pro;
        $this -> repoUser = $repo;
        $this -> validator = $validator;
        $this -> em = $em;
        $this -> weuz = $weuz;
        $this -> agenRepo = $agenRepo;
    }
    /**
     * @Route(path="/api/19weuzy/listeCaissiers", name="listeCaissiers", methods="get"),
     */
    public function listeCaissiers() {
        $users = $this -> repoUser -> getUser();
        return $this -> json($users, Response::HTTP_OK);
    }

    /**
     * @Route(path="/api/19weuzy/bloquageCaissier/{id}", name="bloquageCaissier", methods="patch"),
     */
    public function bloquageCaissier(int $id) {
        $user = $this -> repoUser -> find($id);
        if ($user->getProfil()->getLibelle() === 'Caissier') {
            $user -> setIsBlocked(1);
            $this->em->persist($user);
            $this -> em ->flush();
            return $this -> json($user, Response::HTTP_OK);
        }
        return new JsonResponse('l\'utilisateur doit être un \'caissier\' ', Response::HTTP_BAD_REQUEST);

    }

    /**
     * @Route(path="/api/19weuzy/user", name="getUserConnect", methods="get"),
     */
    public function getUsername(SerializerInterface $serializer)
    {
        $user = $this->getUser();
        $user=$serializer->normalize($user, 'JSON', ['groups' => 'connectUser']);
        return new JsonResponse($user, Response::HTTP_OK);

    }
    /**
     * @Route("/api/19weuzy/users", name="add_user", methods="post"),
     */
    public function index(Request $request)
    {
        $user = $request -> request -> all();
        $use = new User();
        $photo = $request -> files -> get('photo');
            $profil = $this -> pro -> findOneByLibelle($user['profils']);
        if (isset($user['agence'])) {
            $idAgence = (int)$user['agence'];
            unset($user['agence']);
            $agence = $this -> agenRepo ->find($idAgence);
            $use -> setAgence($agence);
        } else {
            $use -> setAgence(null);
        }
            // $user = $this -> serializer -> denormalize($user, "App\Entity\\" . $user['profils']);
             $use -> setProfil($profil)
                  -> setEmail($user['email'])
                  -> setPrenom( $user['prenom'] )
                  -> setNom( $user['nom'] )
                  -> setTelephone( $user['telephone'] )
                  -> setUsername( $user['username'] )
                  -> setRoles(['ROLE_'.$profil -> getLiBelle()]);
            // TODO set Photo
            if (!$photo) {
                return new JsonResponse('veuillez mettre une image', Response::HTTP_BAD_REQUEST, [], true);
            }
            $photoBlob = fopen($photo -> getRealPath(), 'rb');
            $use -> setPhoto($photoBlob);
            // TODO validations User
            $errors = $this -> validator -> validate($user);
            if (count($errors)) {
                $errors = $this -> serializer -> serialize($errors, 'json');
                return new JsonResponse($errors, Response:: HTTP_BAD_REQUEST, [], true);
            }
             // TODO setPassword
             $password = '#19weuzy';
             $use -> setPassword($this -> encoder -> encodePassword($use, $password));
             if ($this -> encoder -> encodePassword($use, $password)) {
                 $this -> em -> persist($use);
                 $this -> em -> flush();
                 return new JsonResponse('User added to success', Response:: HTTP_CREATED);
             } else {
                 return new JsonResponse('Password not work', Response::HTTP_INTERNAL_SERVER_ERROR);
             }
    }
    /**
     * @Route("/api/19weuzy/users/{id}", name="edit_user", methods="put")
     */
    public function editUser(int $id, Request $request)
    {
        $user = $this -> repoUser -> find($id);
        $up = $request -> getContent();
        $cut = preg_split("/form-data; /", $up);
        unset($cut[0]);
        $data =[];
        foreach ($cut as $item) {
            $cool = preg_split("/\r\n/", $item);
            array_pop($cool);
            array_pop($cool);
            $find = explode('"', $cool[0]);
            $data[$find[1]] = end($cool);
        }
        if (isset($data["photo"])) {
           $stream = fopen('php://memory', 'r+');
           fwrite($stream, $data['photo']);
           rewind($stream);
           $data['photo'] = $stream;
        }
        foreach ($data as $item => $value) {
            if ($item !== "profils") {
                $setProperty = 'set'.ucfirst($item);
                $user -> $setProperty($value);
             }
         }
        $this -> em -> flush();
        return $this -> json("Utilisateur modifié avec success", Response::HTTP_OK);
 

    }
}
