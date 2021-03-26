import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { IndexPage } from './index.page';
import {LoginGuard} from '../guards/login.guard';

const routes: Routes = [
  {
    path: '',
    component: IndexPage,
    children: [
      {
        path: '',
        loadChildren: () =>
         import('../pages/welcome/welcome.module').then(
            m => m.WelcomePageModule)
      },
      {
        path: 'login',
        loadChildren: () =>
         import('../pages/login/login.module').then(
            m => m.LoginPageModule)
      },
      {
        path: 'depot',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/depot/depot.module').then( m => m.DepotPageModule)
      },
      {
        path: 'retrait',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/retrait/retrait.module').then( m => m.RetraitPageModule)
      },
      {
        path: 'transactions',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/transactions/tranactions.module').then(m => m.TranactionsPageModule)
      },
      {
        path: 'comissions',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/comissions/comissions.module').then( m => m.ComissionsPageModule)
      },
      {
        path: 'calculFrais',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/calcul-frais/calcul-frais.module').then( m => m.CalculFraisPageModule)
      },
      {
        path: 'tabs',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/tabs/tabs.module').then( m => m.TabsPageModule)
      },
      {
        path: 'mes-transactions',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/mes-transactions/mes-transactions.module').then( m => m.MesTransactionsPageModule)
      },
      {
        path: 'caissiers',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/caissiers/caissiers.module').then( m => m.CaissiersPageModule)
      },
      {
        path: 'agences',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/agences/agences.module').then( m => m.AgencesPageModule)
      },
      {
        path: 'depot-compte',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/depot-compte/depot-compte.module').then( m => m.DepotComptePageModule)
      },
      {
        path: 'tabs-admin',
        canActivate: [LoginGuard],
        loadChildren: () => import('../pages/tabs-admin/tabs-admin.module').then( m => m.TabsAdminPageModule)
      },
      {
        path: 'depots-caissier',
        loadChildren: () => import('../pages/depots-caissier/depots-caissier.module').then( m => m.DepotsCaissierPageModule)
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class IndexPageRoutingModule {}
