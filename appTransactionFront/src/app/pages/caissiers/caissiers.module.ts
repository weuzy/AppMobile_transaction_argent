import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CaissiersPageRoutingModule } from './caissiers-routing.module';

import { CaissiersPage } from './caissiers.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    CaissiersPageRoutingModule
  ],
  declarations: [CaissiersPage]
})
export class CaissiersPageModule {}
