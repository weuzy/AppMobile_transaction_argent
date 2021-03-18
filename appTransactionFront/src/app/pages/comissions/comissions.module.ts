import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ComissionsPageRoutingModule } from './comissions-routing.module';

import { ComissionsPage } from './comissions.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ComissionsPageRoutingModule
  ],
  declarations: [ComissionsPage]
})
export class ComissionsPageModule {}
