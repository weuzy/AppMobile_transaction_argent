import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {BehaviorSubject, Observable} from 'rxjs';
import {User} from '../models';
import {map} from 'rxjs/operators';
import {environment} from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  /*private currentUserSubject: BehaviorSubject<User>;
  public currentUser: Observable<User>;*/
  link =  '/api/login';
  constructor(private http: HttpClient) {
   /* this.currentUserSubject = new  BehaviorSubject<User>(JSON.parse(localStorage.getItem('currentUser')));
    this.currentUser = this.currentUserSubject.asObservable();*/
  }
  /*public get CurrentUserValue(): User {
    return this.currentUserSubject.value;
  }*/
/*
  login(username: string, password: string) {
    return this.http.post<any>(this.link, {username, password})
      .pipe(map(user => {
        if (user && user.token) {
          localStorage.setItem('currentUser', JSON.stringify(user));
          this.currentUserSubject.next(user);
        }
        return user;
      }));
  }
  logout() {
    localStorage.removeItem('currentUser');
    this.currentUserSubject.next(null);
  }
*/
  isLogged(): any {
    return !! localStorage.getItem('token');
  }
  login(postData): Observable<any> {
    return this.http.post(this.link, postData);
  }
  logout(): void {
    localStorage.removeItem('token');
    localStorage.clear();
  }
  getRoles() {
    return localStorage.getItem('role');
  }
}
