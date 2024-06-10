import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import jwt_decode from 'jwt-decode';


@Injectable({
  providedIn: 'root'
})
export class LoginService {
  private tokenKey = 'TokenJWT';

  constructor(private http: HttpClient) { }

  url="http://localhost:8000/login";


  public login(body: any) {
    return this.http.post(this.url, body);
  }

  public setToken(token: string, rememberMe: boolean) {
    if (rememberMe) {
      localStorage.setItem(this.tokenKey, token);
    } else {
      sessionStorage.setItem(this.tokenKey, token);
    }
  }

  public getToken(): string | null {
    return localStorage.getItem(this.tokenKey) || sessionStorage.getItem(this.tokenKey);
  }

  public getDecodedToken(): any {
    const token = this.getToken();
    return token ? jwt_decode(token) : null;
  }

  public getUserRole(): string {
    const decodedToken = this.getDecodedToken();
    return decodedToken ? decodedToken.rolName : null;
  }

  public isLoggedIn(): boolean {
    return this.getToken() !== null;
  }

  public logout(): void {
    localStorage.removeItem(this.tokenKey);
    sessionStorage.removeItem(this.tokenKey);
  }

}
