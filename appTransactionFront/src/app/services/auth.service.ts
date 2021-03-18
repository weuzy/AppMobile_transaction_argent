import { Injectable } from '@angular/core';
import {environment} from '../../environments/environment.prod';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  link = environment.urlAdress + 'login';
  constructor(private http: HttpClient) { }
  isLogged(): any {
    return !! localStorage.getItem('token');
  }
  login(postData): Observable<any> {
    return this.http.post(this.link, postData);
  }
  logout(): void {
    localStorage.removeItem('token');
  }
}
