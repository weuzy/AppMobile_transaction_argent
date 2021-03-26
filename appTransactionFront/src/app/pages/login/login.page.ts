import { Component, OnInit } from '@angular/core';
import {AuthService} from '../../services/auth.service';
import {Router} from '@angular/router';
import {JwtHelperService} from '@auth0/angular-jwt';
import {ToastService} from '../../services/toast.service';
import {LoadingController} from '@ionic/angular';


@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  postData = {
    username: '',
    password: ''
  };

  helper = new JwtHelperService();
  constructor(
    private authService: AuthService,
    private router: Router,
    private toastService: ToastService,
    private loadingCrtl: LoadingController
  ) { }

  ngOnInit() {
  }
  validateInputs() {
    const username = this.postData.username.trim();
    const password = this.postData.password.trim();
    return (
      this.postData.username &&
      this.postData.password &&
      username.length > 0 &&
      password.length > 0
    );
  }
  toConnect() {
      if (this.validateInputs()) {
        this.authService.login(this.postData).subscribe(
          (response: any) => {
            console.log(response);
            if (response.token) {
              const tokenDecode = this.helper.decodeToken(response.token);
              console.log(tokenDecode);
              localStorage.setItem('token', response.token);
              localStorage.setItem('role', tokenDecode.roles);
              localStorage.setItem('username', tokenDecode.username);
              if (localStorage.getItem('role') === 'ROLE_AdminAgence' || localStorage.getItem('role') === 'ROLE_UtilisateurAgence') {
                this.loadingCrtl.create({
                  spinner: 'lines-small',
                  showBackdrop: false,
                  cssClass: 'my-custom-class'
                }).then(loading => {
                  loading.present();
                  setTimeout(() => {
                    loading.dismiss();
                    window.location.href = '/tabs/home';
                  }, 400);
                });
              }
              if (localStorage.getItem('role') === 'ROLE_AdminSysteme' || localStorage.getItem('role') === 'ROLE_Caissier') {
                this.loadingCrtl.create({
                  spinner: 'lines-small',
                  showBackdrop: false,
                  cssClass: 'my-custom-class'
                }).then(loading => {
                  loading.present();
                  setTimeout(() => {
                    loading.dismiss();
                    window.location.href = '/tabs-admin/admin';
                  }, 100);
                });
              } /*else {
                this.toastService.presentToast('vous n\'avez pas le droit d\'accés à cette application!!');
              }*/
            } else {
              this.toastService.presentToast('le nom d\'utilisateur ou le mot de' +
                'de passe est incorrect');
            }
          },
          (error: any) => {
            this.toastService.presentToast('Le nom d\'utilisateur ou' +
              ' le mot de passe n\'a pas été reconnu');
          }
        );
      } else {
        this.toastService.presentToast(
          'le nom d\'utilisateur et le mot' +
          'de passe sont obligatoire');
      }
  }

}
