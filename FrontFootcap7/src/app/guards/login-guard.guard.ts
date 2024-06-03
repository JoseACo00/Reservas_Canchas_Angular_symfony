import { Injectable, inject } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';


export const LogginGuard = () => {
  const router = inject(Router)
  if (localStorage.getItem('TokenJWT')|| sessionStorage.getItem('TokenJWT')){
    return true;
  } else {
      // RETORMANOS A LA PAGINA QUE QUERAMOS
      router.navigate(['Login']);
    return false;
  }
}
