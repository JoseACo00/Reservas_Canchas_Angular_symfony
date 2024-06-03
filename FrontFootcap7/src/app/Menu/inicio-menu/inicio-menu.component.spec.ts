import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InicioMenuComponent } from './inicio-menu.component';

describe('InicioMenuComponent', () => {
  let component: InicioMenuComponent;
  let fixture: ComponentFixture<InicioMenuComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InicioMenuComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(InicioMenuComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
