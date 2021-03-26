import {Compte} from './compte';

export interface Agence {
  id: number;
  nom: string;
  adresse: string;
  telephone: string;
  compte: Compte;
}
