import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse} from '@angular/common/http';
import {catchError, map} from 'rxjs/operators';
import {environment} from '../../environments/environment';
import {Observable, throwError} from 'rxjs';
import {Transaction} from '../models/transaction';
import {User} from "../models";

@Injectable({
  providedIn: 'root'
})
export class UserService {
/*
  link = '/api/19weuzy/user';
*/
  constructor(
    private http: HttpClient
  ) { }
  private handleError(errorResponse: HttpErrorResponse) {
    if (errorResponse.error instanceof ErrorEvent) {
      console.log('Erreur côté client:', errorResponse.message);
    } else {
      console.log('Erreur côté serveur:', errorResponse.message);
    }
    return throwError('Il y a un probléme avec le serveur ');
  }
  calculatriceFrais(credentials) {
    // @ts-ignore
    return this.http.post<any>(`/api/19weuzy/calculatriceFrais`, credentials).pipe(catchError(UserService.handleError));
  }
  getComissions() {
    // @ts-ignore
    return this.http.get<any>(`/api/19weuzy/commissions`).pipe(catchError(UserService.handleError));
  }
  getUserConnect() {
    // @ts-ignore
    return this.http.get<any>(`/api/19weuzy/user`).pipe(catchError(UserService.handleError));
  }
  getMyTransactions() {
    return this.http.get<any>(`/api/19weuzy/myTransactions`)
      .pipe(catchError(this.handleError));
  }
  getAllTransactions() {
    return this.http.get<any>(`/api/19weuzy/transactions`)
      .pipe(catchError(this.handleError));
  }
  findTransaction(code: string): Observable<Transaction> {
    return this.http.get<Transaction>(`/api/19weuzy/findCodeTransaction/${code}`)
      .pipe(catchError(this.handleError));
  }
  addEnvoiTransaction(transaction: Transaction): Observable<Transaction> {
    return this.http.post<Transaction>(`/api/19weuzy/envoiTransaction`, transaction)
      .pipe(catchError(this.handleError));
  }
  retraitTransaction(transaction: Transaction): Observable<void> {
    return this.http.put<void>(`/api/19weuzy/retraitTransaction/${transaction.codeTransaction}`, transaction)
      .pipe(catchError(this.handleError));
  }
  annulationTransaction(transaction: Transaction): Observable<void> {
    return this.http.put<void>(`/api/19weuzy/annulationTransaction/${transaction.codeTransaction}`, transaction)
      .pipe(catchError(this.handleError));
  }
  getAllCaissiers() {
    return this.http.get<any>(`/api/19weuzy/listeCaissiers`)
      .pipe(catchError(this.handleError));
  }
  addUser(user: User): Observable<User> {
    return this.http.post<User>(`/api/19weuzy/envoiTransaction`, user)
      .pipe(catchError(this.handleError));
  }
}
