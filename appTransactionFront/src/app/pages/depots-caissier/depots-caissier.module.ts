import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { DepotsCaissierPageRoutingModule } from './depots-caissier-routing.module';

import { DepotsCaissierPage } from './depots-caissier.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    DepotsCaissierPageRoutingModule
  ],
  declarations: [DepotsCaissierPage]
})
export class DepotsCaissierPageModule {}
