import { Component, OnInit } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {AlertController} from '@ionic/angular';
import {Transaction} from '../../models/transaction';
import {UserService} from '../../services/user.service';

@Component({
  selector: 'app-mes-transactions',
  templateUrl: './mes-transactions.page.html',
  styleUrls: ['./mes-transactions.page.scss'],
})
export class MesTransactionsPage implements OnInit {

  data = [];
  sortDirection = 0;
  sortKey = null;
  total = 0;
  trans: Transaction;
  constructor(private userAuth: UserService, private alertController: AlertController) {
    this.loadData();
  }
  loadData() {
    this.userAuth.getMyTransactions().subscribe(
      res => {
        console.log('res_', res);
        // @ts-ignore
        this.data = res;
        this.sort();
        if (this.data !== []) {
          for (const m of this.data){
            this.total = this.total + m.montant;
          }
        }
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
        // console.log('a_', a);
        const  valA = a[this.sortKey];
        const valB = b[this.sortKey];
        return valA.localeCompare(valB);
      });
    } else if (this.sortDirection === 2) {
      this.data = this.data.sort((a, b) => {
       // console.log('a_', a);
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
