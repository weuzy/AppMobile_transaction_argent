import { Component, OnInit } from '@angular/core';
import {User} from '../models';
import {UserService} from '../services/user.service';
import {NavController} from '@ionic/angular';
import {Router} from '@angular/router';
import {AuthService} from '../services/auth.service';

@Component({
  selector: 'app-home-admin',
  templateUrl: './home-admin.page.html',
  styleUrls: ['./home-admin.page.scss'],
})
export class HomeAdminPage implements OnInit {
  user: User;
  constructor(
    private userAuth: UserService,
    private navCtrl: NavController,
    private router: Router,
    private auth: AuthService
  ) {
    this.userAuth.getUserConnect().subscribe(
      (data) => {
        this.user = data;
      });
  }

  logout(): void {
    this.auth.logout();
    this.navCtrl.navigateForward(['/login']);
  }

  ngOnInit(): void {
    this.getRoles();
  }
  getRoles() {
    return localStorage.getItem('role');
  }

}
