import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/map';
import { Observable } from 'rxjs/Observable';
import { HttpClientModule } from '@angular/common/http';

@Injectable()
export class AuthProvider {

  private headers = new Headers({'Content-Type': 'application/json'});
  private options = new RequestOptions({headers: this.headers});

  authApiUrl: string = 'http://localhost:8000/api/auth/';

  constructor(public http: HttpClient) {
    console.log('Hello AuthProvider Provider');
  }

  login(email:string, password: string): Observable<any> {
    return this.http.post(this.authApiUrl + 'signin', {email, password}, this.options)
    .map(res => res);
  }

}
