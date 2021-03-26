import { Component, OnInit } from '@angular/core';
import {LoadingController} from '@ionic/angular';
import {Router} from '@angular/router';

@Component({
  selector: 'app-welcome',
  templateUrl: './welcome.page.html',
  styleUrls: ['./welcome.page.scss'],
})
export class WelcomePage implements OnInit {

  constructor(
    private loadingCrtl: LoadingController,
    private router: Router
  ) { }

  ngOnInit() {
    this.loadingCrtl.create({
      cssClass: 'my-custom-class',
    }).then(loading => {
      loading.present();
      setTimeout(() => {
        loading.dismiss();
        this.router.navigate(['/login']);
      }, 1500);
    });
  }

}
