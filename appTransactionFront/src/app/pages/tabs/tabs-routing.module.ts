import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabsPage } from './tabs.page';

const routes: Routes = [
  {
    path: '',
    component: TabsPage,
    children: [
      {
        path: 'home',
        children: [
          {
            path: '',
            loadChildren: () => import('../../home/home.module').then( m => m.HomePageModule)
          }
        ]
      },
      {
        path: 'transactions',
        loadChildren: () => import('../../pages/transactions/tranactions.module').then(m => m.TranactionsPageModule)
      },
      {
        path: 'comissions',
        loadChildren: () => import('../../pages/comissions/comissions.module').then( m => m.ComissionsPageModule)
      },
      {
        path: 'calculFrais',
        loadChildren: () => import('../../pages/calcul-frais/calcul-frais.module').then( m => m.CalculFraisPageModule)
      },
      {
        path: 'mes-transactions',
        loadChildren: () => import('../../pages/mes-transactions/mes-transactions.module').then( m => m.MesTransactionsPageModule)
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabsPageRoutingModule {}
