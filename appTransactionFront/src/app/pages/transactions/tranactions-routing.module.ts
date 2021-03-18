import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TranactionsPage } from './tranactions.page';

const routes: Routes = [
  {
    path: '',
    component: TranactionsPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TranactionsPageRoutingModule {}
