import { Component, OnInit } from '@angular/core';
import {UserService} from '../../services/user.service';
import {AlertController} from '@ionic/angular';

@Component({
  selector: 'app-comissions',
  templateUrl: './comissions.page.html',
  styleUrls: ['./comissions.page.scss'],
})
export class ComissionsPage implements OnInit {
  data = [];
  sortDirection = 0;
  sortKey = null;
  total = 0;
  constructor(private userAuth: UserService, private alertController: AlertController) {
    this.loadData();
  }
  loadData() {
    this.userAuth.getComissions().subscribe(
      res => {
        console.log('res_', res);
        // @ts-ignore
        this.data = res;
        this.sort();
        /*if (this.data !== []) {
          for (const m of this.data){
            this.total = this.total + m.montant;
          }
        }*/
      },
      error => {
        this.alertController.create({
          header: 'Erreur Service! ' + error,
          message: 'Veuiller reessayer',
          buttons: ['ok']
        }).then(result1 => {
          result1.present();
        });
      }
    );
  }
  sortBy(key) {
    this.sortKey = key;
    this.sortDirection++;
    this.sort();
  }

  sort() {
    if (this.sortDirection === 1) {
      this.data = this.data.sort((a, b) => {
        console.log('a_', a);
        const  valA = a[this.sortKey];
        const valB = b[this.sortKey];
        return valA.localeCompare(valB);
      });
    } else if (this.sortDirection === 2) {
      this.data = this.data.sort((a, b) => {
        console.log('a_', a);
        const  valA = a[this.sortKey];
        const valB = b[this.sortKey];
        return valB.localeCompare(valA);
      });
    } else {
      this.sortDirection = 0;
      this.sortKey = null;
    }
  }

  ngOnInit() {
  }

}
