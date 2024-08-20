import { Component } from '@angular/core';
import { LoginService } from '../services/Loggin/login.service';
import { Router } from '@angular/router';
import { NotificationsService } from 'angular2-notifications';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent {

  isLoggedIn: boolean = false;
  isAdmin: boolean = false;
  isUser: boolean = false;
  isArbitro: boolean = false;
  constructor(private loginService: LoginService,  private router: Router,private notifications: NotificationsService) { }


   //ALERTAS
   onSuccess(message: string) {
    this.notifications.success('Correcto con padre', message, {
      position: ['top', 'middle'],
      animate: 'fromRight',
      showProgressBar: true,
      timeOut: 2000
    });
  }
  onError(message: string) {
    this.notifications.error('Cuenta  Cerrada', message, {
      position: ["top", "center"], // Configuración de posición
      animate: 'fromTop',
      showProgressBar: true,
      timeOut: 4000
    });
  }
  ngOnInit(): void {
    this.isLoggedIn = this.loginService.isLoggedIn();
    if (this.isLoggedIn) {
      const role = this.loginService.getUserRole();
      this.isUser = role === 'Usuario';
      this.isAdmin = role === 'Admin';
      this.isArbitro = role === 'Arbitro';
    }
  }

  logout(): void {
    this.loginService.logout();
    this.onError('Has salido de tú cuenta');
    setTimeout(()=>{this.router.navigate(['/Login'])}, 3000);

  }
}
