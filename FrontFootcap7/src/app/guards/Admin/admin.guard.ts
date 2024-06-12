import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';
import { LoginService } from 'src/app/services/Loggin/login.service';

@Injectable({
  providedIn: 'root'
})
export class AdminGuard implements CanActivate {


  constructor(private loginService: LoginService, private router: Router) {}

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
    const isAdmin = this.loginService.getUserRole() === 'Admin';
    if (!isAdmin) {
      this.router.navigate(['/Login']);
      return false;
    }
    return true;
  }
}
