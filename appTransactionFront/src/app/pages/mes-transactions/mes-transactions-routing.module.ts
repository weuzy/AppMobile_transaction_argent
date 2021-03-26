import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { MesTransactionsPage } from './mes-transactions.page';

const routes: Routes = [
  {
    path: '',
    component: MesTransactionsPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class MesTransactionsPageRoutingModule {}
