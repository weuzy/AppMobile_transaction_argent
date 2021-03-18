import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ComissionsPage } from './comissions.page';

const routes: Routes = [
  {
    path: '',
    component: ComissionsPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ComissionsPageRoutingModule {}
