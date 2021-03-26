import {Component, OnDestroy, OnInit} from '@angular/core';
import {MenuController, NavController} from '@ionic/angular';
import {AuthService} from './services/auth.service';
import {UserService} from './services/user.service';
import {User} from './models';
import {Router} from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})
export class AppComponent implements OnInit {
  user: User;
  activePath: any;
  rootPath: any = '/transactions';
  pages = [
    {
      name: 'Mes transactions',
      path: '/transactions',
      icon: 'sync-outline'
    },
    {
      name: 'Mes comissions',
      path: '/comissions',
      icon: 'server-outline'
    },
    {
      name: 'Calculateur frais',
      path: '/calculFrais',
      icon: 'calculator'
    }
  ];
  constructor(
    private menu: MenuController,
    private navCrl: NavController,
    private auth: AuthService,
    private userAuth: UserService,
    private router: Router,
  ) {
    this.userAuth.getUserConnect().subscribe(
      (data) => {
        this.user = data;
      });
  }
  ngOnInit(): void {
    this.getRoles();
    this.activePath = false;
    if (this.getRoles() === 'ROLE_UtilisateurAgence') {
      this.pages = [{
          name: 'Mes transactions', path: '/mes-transactions', icon: 'sync-outline' }, {
          name: 'Calculateur frais', path: '/calculFrais', icon: 'calculator'
        }];
    }
    if (this.getRoles() === 'ROLE_AdminAgence') {
      // @ts-ignore
        this.pages = [{
          name: 'Mes transactions', path: '/mes-transactions', icon: 'sync-outline' }, {
          name: 'Mes comissions', path: '/comissions', icon: 'server-outline'}, {
          name: 'Calculateur frais', path: '/calculFrais', icon: 'calculator'
        }];
    }
    if (this.getRoles() === 'ROLE_AdminSysteme') {
      // @ts-ignore
        this.pages = [{
          name: 'Listes des Caissiers', path: '/caissiers', icon: 'list-circle-outline' }, {
          name: 'Chargement d\'un compte', path: '/depotCompte', icon: 'wallet-outline'}, {
          name: 'Listes des Agences', path: '/agences', icon: 'business-outline'
        }];
    }
    if (this.getRoles() === 'ROLE_Caissier') {
      // @ts-ignore
        this.pages = [{
          name: 'Listes des Caissiers', path: '/caissiers', icon: 'list-circle-outline' }, {
          name: 'Mes dépots', path: '/depotCompte', icon: 'wallet-outline'}
        ];
    }
  }

  getRoles() {
    return localStorage.getItem('role');
  }
  logout(): void {
    this.auth.logout();
    this.menu.close();

    this.router.navigate(['/login'], {replaceUrl: true});
  }
  menuClicked() {
    this.menu.close();
  }
  checkActiveLink(page) {
    return page === this.activePath;
  }
  openLink(page) {
    this.navCrl.navigateRoot(page.path);
    this.activePath = page;
  }


}
