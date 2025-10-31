import { Pipe, PipeTransform } from '@angular/core';

@Pipe({ name: 'priceByActivity', standalone: true })
export class PriceByActivityPipe implements PipeTransform {
  transform(price: number, activity?: 'short'|'long'|'sale'|null): string {
    if (price == null) return '';
    const p = new Intl.NumberFormat('fr-BE', { style: 'currency', currency: 'EUR' }).format(price);
    switch (activity) {
      case 'short': return `${p} / jour`;
      case 'long':  return `${p} / mois`;
      default:      return p;
    }
  }
}
