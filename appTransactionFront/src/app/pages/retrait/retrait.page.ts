import {AfterViewInit, ChangeDetectorRef, Component, OnInit} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {AlertController, NavController} from '@ionic/angular';
import {UserService} from '../../services/user.service';
import {Transaction} from '../../models/transaction';
import {FraisService} from '../../services/frais.service';

@Component({
  selector: 'app-retrait',
  templateUrl: './retrait.page.html',
  styleUrls: ['./retrait.page.scss'],
})
export class RetraitPage implements OnInit, AfterViewInit {
  transaction: Transaction;
  code: string;
  selectedSegment = 'emetteur';
  retraitForm: FormGroup;
  submitted: boolean;
  constructor(
    private cd: ChangeDetectorRef,
    private fb: FormBuilder,
    public alertController: AlertController,
    private navCntroller: NavController,
    private transService: UserService,
    public  myfraisService: FraisService
  ) { }

  segmentChanged(ev) {
    console.log(ev.target.value);
    this.selectedSegment = ev.target.value;
  }
  ngOnInit() {
    this.retraitForm = this.fb.group({
      cniRecepteur: new FormControl('', [Validators.required, Validators.pattern('^[1|2][0-9]{12}$')]),
      codeTransaction: new FormControl ('', Validators.required),
    });

  }
  ngAfterViewInit() {
     this.selectedSegment = 'emetteur';
     this.cd.detectChanges();
  }
  get fo() {
    return this.retraitForm.controls;
  }
  getTransaction() {
    if (this.retraitForm.get('codeTransaction').errors === null) {
      this.transService.findTransaction(this.code).subscribe(
        data => {
          this.transaction = data;
          console.log(this.transaction.montant);
        }
      );
    }
  }
  onSubmit() {
    this.submitted = true;
    if (this.retraitForm.valid) {
      this.alertController.create({
        header: 'Confirmation du retrait',
        cssClass: 'my-class',
        message: '<ion-list>' +
          '<ion-item>' +
            '<ion-label>BÉNÉFICIAIRE: ' + this.transaction.prenomRecepteur + '' + this.transaction.prenomRecepteur + '</ion-label>' +
          '</ion-item>' +
          '<ion-item>' +
            '<ion-label>TELEPHONE: ' + this.transaction.telephoneRecepteur + '</ion-label>' +
          '</ion-item>' +
          '</ion-list>',
        buttons: [
          {
            text: 'Annuler',
            cssClass: 'danger',
            handler: () => {
              this.transService.annulationTransaction(this.retraitForm.value).subscribe(
                response => {
                  this.alertController.create({
                    header: 'Transaction annulée',
                    message: '' + response,
                    buttons: [
                      {
                        text: 'ok',
                        handler: () => {
                          this.navCntroller.navigateForward('/tabs/home');
                        }
                      }
                    ],
                    cssClass: 'my-class'
                  }).then(
                    result => { result.present(); });
                }, error => {
                  this.alertController.create({
                    header: 'Erreur ! ' + error,
                    message: 'Veuillez reessayer'
                  }).then(result => {
                    result.present();
                  });
                });
            }
          },
          {
            text: 'Valider',
            cssClass: 'success',
            handler: () => {
              this.transService.retraitTransaction(this.retraitForm.value).subscribe(
                response => {
                    this.alertController.create({
                      header: 'Transaction réuissi',
                      message: '' + response,
                      buttons: [
                        {
                          text: 'ok',
                          handler: () => {
                            this.navCntroller.navigateForward('/tabs/home');
                          }
                        }
                      ],
                      cssClass: 'my-class'
                    }).then(
                      result => { result.present(); });
                }, error => {
                  console.log(error);
                  this.alertController.create({
                    header: 'Erreur ! ' + error,
                    message: 'Cette transaction a été bel et bien retirée ou annulée',
                    buttons: [
                      {
                        text: 'OK'
                      }
                    ]
                  }).then(result => {
                    result.present();
                  });
                });
            }
          }
        ]
      }).then(result => {
        result.present();
      });
    }
  }

}
