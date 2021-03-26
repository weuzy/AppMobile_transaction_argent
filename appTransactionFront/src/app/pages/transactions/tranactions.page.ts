import { Component, OnInit } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {AlertController} from "@ionic/angular";

@Component({
  selector: 'app-tranactions',
  templateUrl: './tranactions.page.html',
  styleUrls: ['./tranactions.page.scss'],
})
export class TranactionsPage implements OnInit {
  page = 1;
  totalPage = 10;
  edit = {};
  total = 0;
  // tslint:disable-next-line:ban-types
  data = [];
  bulkEdit = false;
  sortDirection = 0;
  sortKey = null;

  constructor(private http: HttpClient, private alertController: AlertController) {
    this.loadData();
  }
  loadData() {
    this.http.get(`/api/19weuzy/transactions`).subscribe(
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
          message: 'Veuiller reessayer'
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
  /*toggleBulkEdit() {
    this.bulkEdit = !this.bulkEdit;
    this.edit = {};
  }
  toggleBulkDelete() {
    console.log('this.edit', this.edit);
    const toDelete = Object.keys(this.edit);
    console.log(toDelete);
    const reallyDelete = toDelete.filter(index => this.edit[index]).map(key => +key);
    while (reallyDelete.length) {
      this.data.splice(reallyDelete.pop(), 1);
    }
    this.toggleBulkEdit();
  }

  removeRow(index) {
    this.data.splice(index, 1);
  }

  nextPage() {
    this.page++;
    this.loadData();
  }
  prevPage() {
    this.page--;
    this.loadData();
  }
  goFirst() {
    this.page = 1;
    this.loadData();
  }
  goLast() {
    this.page = this.totalPage - 1;
    this.loadData();
  }*/

  ngOnInit() {
  }

}
