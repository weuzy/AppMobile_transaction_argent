import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { CaissiersPage } from './caissiers.page';

const routes: Routes = [
  {
    path: '',
    component: CaissiersPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CaissiersPageRoutingModule {}
