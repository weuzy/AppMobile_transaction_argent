import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CalculFraisPageRoutingModule } from './calcul-frais-routing.module';

import { CalculFraisPage } from './calcul-frais.page';

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        IonicModule,
        CalculFraisPageRoutingModule,
        ReactiveFormsModule
    ],
  declarations: [CalculFraisPage]
})
export class CalculFraisPageModule {}
