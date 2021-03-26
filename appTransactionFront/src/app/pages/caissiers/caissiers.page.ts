import { Component, OnInit } from '@angular/core';
import {User} from '../../models';
import {UserService} from '../../services/user.service';
import {ModalController, NavController} from '@ionic/angular';
import {Router} from '@angular/router';
import {AuthService} from '../../services/auth.service';
import {AddUserComponent} from '../../add-user/add-user.component';

@Component({
  selector: 'app-caissiers',
  templateUrl: './caissiers.page.html',
  styleUrls: ['./caissiers.page.scss'],
})
export class CaissiersPage implements OnInit {
  user: User;
  caissier = [];
  constructor(
    private userAuth: UserService,
    private navCtrl: NavController,
    private router: Router,
    private auth: AuthService,
    private modalCrl: ModalController
  ) {
    this.userAuth.getUserConnect().subscribe(
      (data) => {
        this.user = data;
      });
  }

  ngOnInit() {
    this.allCaissiers();
  }
  allCaissiers() {
    this.userAuth.getAllCaissiers().subscribe(
      data => {
        // console.log(data);
        this.caissier = data;
      });
  }
  async addCaissier() {
    const modal = await this.modalCrl.create({
      component: AddUserComponent
    });
    await modal.present();
  }
}
