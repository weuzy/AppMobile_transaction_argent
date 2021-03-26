import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabsAdminPage } from './tabs-admin.page';

const routes: Routes = [
  {
    path: '',
    component: TabsAdminPage,
    children: [
      {
        path: 'admin',
        children: [
          {
            path: '',
            loadChildren: () => import('../../home-admin/home-admin.module').then( m => m.HomeAdminPageModule)
          }
        ]
      },
      {
        path: 'caissiers',
        loadChildren: () => import('../../pages/caissiers/caissiers.module').then( m => m.CaissiersPageModule)
      },
      {
        path: 'agences',
        loadChildren: () => import('../../pages/agences/agences.module').then( m => m.AgencesPageModule)
      },
      {
        path: 'depot-compte',
        loadChildren: () => import('../../pages/depot-compte/depot-compte.module').then( m => m.DepotComptePageModule)
      },
      {
        path: 'depots-caissier',
        loadChildren: () => import('../../pages/depots-caissier/depots-caissier.module').then( m => m.DepotsCaissierPageModule)
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabsAdminPageRoutingModule {}
