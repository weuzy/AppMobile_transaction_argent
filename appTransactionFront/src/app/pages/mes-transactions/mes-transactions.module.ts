import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { MesTransactionsPageRoutingModule } from './mes-transactions-routing.module';

import { MesTransactionsPage } from './mes-transactions.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MesTransactionsPageRoutingModule
  ],
  declarations: [MesTransactionsPage]
})
export class MesTransactionsPageModule {}
