import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditCanchaComponent } from './edit-cancha.component';

describe('EditCanchaComponent', () => {
  let component: EditCanchaComponent;
  let fixture: ComponentFixture<EditCanchaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ EditCanchaComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EditCanchaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
