import {Injectable} from '@angular/core';
import {AuthService} from '../services/auth.service';
import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Observable} from 'rxjs';


@Injectable()
export class JwtInterceptor implements HttpInterceptor{
  constructor(private authService: AuthService) {}
  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const token = localStorage.getItem('token');
    if (token) {
      // console.log(token);
      const cloneReq = request.clone(
        {
          setHeaders: {
            Authorization: `Bearer ${token}`,
            Accept: 'Application/json'
          }
        }
      );
      // console.log(cloneReq);
      return next.handle(cloneReq);
    } else {
      return next.handle(request);
    }
  }
}
