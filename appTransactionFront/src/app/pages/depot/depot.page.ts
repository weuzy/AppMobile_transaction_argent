import {AfterViewInit, ChangeDetectorRef, Component, OnInit} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {AlertController, NavController} from '@ionic/angular';
import {UserService} from '../../services/user.service';
import {FraisService} from '../../services/frais.service';
import {Transaction} from '../../models/transaction';

@Component({
  selector: 'app-depot',
  templateUrl: './depot.page.html',
  styleUrls: ['./depot.page.scss'],
})
export class DepotPage implements OnInit, AfterViewInit {

  selectedSegment = 'emetteur';
  depotForm: FormGroup;
  montantCtl = new FormControl(0);
  submitted: boolean;
  fraisCtl = new FormControl(0);
  transaction: Transaction;
  constructor(
    private cd: ChangeDetectorRef,
    private fb: FormBuilder,
    public alertController: AlertController,
    private userService: UserService,
    public myFraisService: FraisService,
    private navCntroller: NavController,
  ) {}
  segmentChanged(ev) {
    console.log(ev.target.value);
    this.selectedSegment = ev.target.value;
  }
  ngOnInit() {
    this.depotForm = this.fb.group({
      // emetteur: new FormGroup({
        montant: new FormControl ('', [Validators.required, Validators.pattern('^[0-9]+$')]),
        cniEmetteur: new FormControl('', [Validators.required, Validators.pattern('^[1|2][0-9]{12}$')]),
        prenomEmetteur: new FormControl('', [Validators.required, Validators.pattern('^[A-Z][a-z A-Z]+$')]),
        nomEmetteur: new FormControl('', [Validators.required, Validators.pattern('^[A-Z]+$')]),
        telephoneEmetteur: new FormControl('', [Validators.required, Validators.pattern('^7[7|6|8|0|5][0-9]{7}$')]),
      // }),
      // beneficiaire: new FormGroup({
        prenomRecepteur: new FormControl('', [Validators.required, Validators.pattern('^[A-Z][a-z A-Z]+$')]),
        nomRecepteur: new FormControl('', [Validators.required, Validators.pattern('^[A-Z]+$')]),
        telephoneRecepteur: new FormControl('', [Validators.required, Validators.pattern('^7[7|6|8|0|5][0-9]{7}$')]),
      // })
    });
  }
  ngAfterViewInit() {
    this.selectedSegment = 'emetteur';
    this.cd.detectChanges();
  }
  get fo() {
    return this.depotForm.controls;
  }
  total() {
    // @ts-ignore
    return this.myFraisService.calculerFrais(this.montantCtl.value) + this.montantCtl.value;
  }
  basse() {
    if (this.montantCtl.value >= 5000) {
      this.depotForm.get('montant').patchValue(this.total()) ;
      this.fraisCtl.setValue(this.myFraisService.calculerFrais(this.montantCtl.value));
    }
  }
  next() {
    /*if (this.selectedSegment === 'emetteur' && this.depotForm.invalid) {
      this.submitted = true;
    } else {
    }*/
    return this.selectedSegment = 'beneficiaire';
    }
  onSubmit() {
    this.submitted = true;
    console.log(this.depotForm.value);
    if (this.depotForm.valid) {
        this.alertController.create({
          header: 'Confirmation du dépot',
          cssClass: 'my-class',
          message: `<div>` +
            `<ion-label><b>Emétteur</b></ion-label><br>` +
            `<i>${this.depotForm.get('prenomEmetteur').value} ${this.depotForm.get('nomEmetteur').value}` +
            `</i>` +
            `</div>` +
            `<div><ion-label>Tétéphone</ion-label><br><i>` +
            `${this.depotForm.get('telephoneEmetteur').value}` +
            `</i></div>` +
            `<div><ion-label>CNI</ion-label><br><i>${this.depotForm.get('cniEmetteur').value}` +
            `</i></div>` +
            `<div><ion-label>Montant</ion-label><br><i>` +
            `${this.depotForm.get('montant').value}` +
            `</i></div>` +
            `<br>` +
            `<div><ion-label><b>Bénéficiaire</b></ion-label><br>` +
            `<i>${this.depotForm.get('prenomRecepteur').value} ${this.depotForm.get('nomRecepteur').value}` +
            `</i></div>` +
            `<div>` +
            `<ion-label>Tétéphone</ion-label>` +
            `<i>${this.depotForm.get('telephoneRecepteur').value}` +
            `</i></div>`,
          buttons: [
            {
              text: 'Annuler',
              handler: (data: any) => {
                console.log('Canceled', data);
              }
            },
            {
              text: 'Confirmer!',
              handler: () => {
                this.userService.addEnvoiTransaction(this.depotForm.value).subscribe(
                  res => {
                    console.log(res);
                    this.transaction = res;
                    console.log(res);
                    this.alertController.create({
                      header: 'transfert réussi',
                      cssClass: 'my-class',
                      buttons: [
                        {
                          text: 'OK',
                          handler: () => {
                            this.navCntroller.navigateForward('/tabs/home');
                          }
                        }
                      ],
                      message: '<ion-grid>' +
                        '<ion-row>' +
                        '<ion-col>' +
                        '<ion-label>INFOS</ion-label>' +
                        // tslint:disable-next-line:max-line-length
                        '<ion-text >votre dépot de ' +  this.depotForm.get('montant').value +
                        // tslint:disable-next-line:max-line-length
                        ' à ' + this.depotForm.get('prenomRecepteur').value + ' ' + this.depotForm.get('nomRecepteur').value +
                        ' le ' + res.dateDepot + '</ion-text>' +
                        '</ion-col>' +
                        '</ion-row>' +
                        '<ion-row>' +
                        '<ion-col>' +
                        '<ion-label>CODE DE TRANSACTION</ion-label>' +
                        // tslint:disable-next-line:max-line-length
                        '<ion-text class="ion-align-items-center"><b>' + res.codeTransaction + '</b></ion-text>' +
                        '</ion-col>' +
                        '</ion-row>' +
                        '</ion-grid>'
                    }).
                    then(rest => {
                      rest.present(); });
                  },
                  err => {
                    this.alertController.create({
                      header: 'il y a une erreur lors de la transaction',
                      message: 'veuillez réessayer ultérieurement'
                    }).then( response => { response.present(); });
                  }
                );
              }
            }
          ]
        }).then(res => {
          res.present();
        });
      }
    }


}
