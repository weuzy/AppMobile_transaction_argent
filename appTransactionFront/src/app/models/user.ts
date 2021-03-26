import {Role} from './role';

export interface User {
  email: string;
  roles: [
      Role
  ];
  prenom: string;
  nom: string;
  telephone: string;
  isBlocked: true;
  photo: string;
  username: string;
  password: string;
  profil: {
    libelle: string;
  };
  agence: {
    nom: string;
    adresse: string;
    telephone: string;
    compte: {
      numeroCompte: string;
      solde: number;
      createAt: Date;
      transactions: [
        {
          dateDepot: Date;
        }
      ]
      depots: [
        {
          id: number;
          dateDepot: Date;
        }
      ]
    };
  };
}
