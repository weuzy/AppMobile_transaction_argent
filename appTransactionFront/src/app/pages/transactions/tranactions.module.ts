import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TranactionsPageRoutingModule } from './tranactions-routing.module';

import { TranactionsPage } from './tranactions.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TranactionsPageRoutingModule
  ],
  declarations: [TranactionsPage]
})
export class TranactionsPageModule {}
