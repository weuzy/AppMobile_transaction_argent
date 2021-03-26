import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {UserService} from '../../services/user.service';
import {AlertController} from '@ionic/angular';

@Component({
  selector: 'app-calcul-frais',
  templateUrl: './calcul-frais.page.html',
  styleUrls: ['./calcul-frais.page.scss'],
})
export class CalculFraisPage implements OnInit {

  calculForm: FormGroup;
  submitted: boolean;

  constructor(
    private fb: FormBuilder,
    private userService: UserService,
    private alertCrl: AlertController
  ) {
  }

  ngOnInit() {
    this.calculForm = this.fb.group({
      type: new FormControl('', [Validators.required]),
      montant: new FormControl('', [Validators.required])
    });
  }

  get fo() {
    return this.calculForm.controls;
  }

  onSubmit() {
    this.submitted = true;
    if (this.calculForm.valid) {
      this.userService.calculatriceFrais(this.calculForm.value).subscribe(
        data => {
          this.alertCrl.create({
            header: 'Calculateur',
            message: 'Pour une transaction de <span><b>' + this.fo.montant.value.toLocaleString() + '</b></span>, \n' +
              'le frais est égal à: \n' +
              '<br>' +
              '<h2><b>' + data.toLocaleString() + '</b></h2>',
            cssClass: 'my-class',
            buttons: ['ok']
          }).then(
            result => {
              result.present();
            });
        }, error => {
          this.alertCrl.create({
            header: 'Erreur !  le type doit être \'dépôt\' ',
            message: 'Veuillez reessayer',
            buttons: ['ok']
          }).then(result => {
            result.present(); });
        }
      );
    }

  }
}
