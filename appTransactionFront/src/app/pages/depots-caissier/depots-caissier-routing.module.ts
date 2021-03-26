import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { DepotsCaissierPage } from './depots-caissier.page';

const routes: Routes = [
  {
    path: '',
    component: DepotsCaissierPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class DepotsCaissierPageRoutingModule {}
