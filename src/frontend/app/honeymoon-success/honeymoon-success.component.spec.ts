import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { HoneymoonSuccessComponent } from './honeymoon-success.component';

describe('HoneymoonSuccessComponent', () => {
  let component: HoneymoonSuccessComponent;
  let fixture: ComponentFixture<HoneymoonSuccessComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ HoneymoonSuccessComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(HoneymoonSuccessComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
