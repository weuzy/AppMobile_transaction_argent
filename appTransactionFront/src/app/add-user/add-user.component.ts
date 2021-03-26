import { Component } from '@angular/core';
import {User} from '../models';
import {UserService} from '../services/user.service';
import {ModalController, NavController} from '@ionic/angular';
import {Router} from '@angular/router';
import {AuthService} from '../services/auth.service';

@Component({
  selector: 'app-add-user',
  templateUrl: './add-user.component.html',
  styleUrls: ['./add-user.component.scss'],
})
export class AddUserComponent {

  user: User;
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

  dismissModal() {
    this.modalCrl.dismiss();
  }
  loadImageFromDevice(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.readAsArrayBuffer(file);
    reader.onload = () => {
      // get the blob of the image:
      const blob: Blob = new Blob([new Uint8Array((reader.result as ArrayBuffer))]);
      // create blobURL, such that we could use it in an image element:
      const blobURL: string = URL.createObjectURL(blob);
    };

    reader.onerror = (error) => {
      // handle errors
      console.log(error);
    };
  }

}
