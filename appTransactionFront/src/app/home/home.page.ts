import {Component, OnInit} from '@angular/core';
import {NavController} from '@ionic/angular';
import {Router} from '@angular/router';
import {AuthService} from '../services/auth.service';
import {UserService} from '../services/user.service';
import {User} from '../models';
import {Transaction} from '../models/transaction';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage implements OnInit {
  user: User;
  date: Date;
  solde: number;
  trans: Transaction;
  viewSolde: boolean;
  constructor(
    private userAuth: UserService,
    private navCtrl: NavController,
    private router: Router,
    private auth: AuthService
  ) {
    this.userAuth.getUserConnect().subscribe(
      (data) => {
       // console.log(data);
        this.solde = data.agence.compte.solde;
       // console.log(this.solde);
        const limit = (data.agence.compte.transactions).length;
        this.trans = (data.agence.compte.transactions) [limit - 1];
        this.date = this.trans.dateDepot;
       // console.log(this.date);
        this.user = data;
      });
  }
  show() {
    // @ts-ignore
    this.viewSolde = !this.viewSolde;
  }
  logout(): void {
    this.auth.logout();
    this.navCtrl.navigateForward(['/login']);
  }

  ngOnInit(): void {
    this.getRoles();
    this.viewSolde = true;
  }
  getRoles() {
    return localStorage.getItem('role');
  }
}
