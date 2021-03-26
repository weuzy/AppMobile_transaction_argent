import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-tabs-admin',
  templateUrl: './tabs-admin.page.html',
  styleUrls: ['./tabs-admin.page.scss'],
})
export class TabsAdminPage implements OnInit {

  constructor() { }

  ngOnInit(): void {
    this.getRoles();
  }
  getRoles() {
    return localStorage.getItem('role');
  }

}
