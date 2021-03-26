import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { DepotComptePage } from './depot-compte.page';

const routes: Routes = [
  {
    path: '',
    component: DepotComptePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class DepotComptePageRoutingModule {}
