import { Pipe, PipeTransform } from '@angular/core';
import { DomSanitizer, SafeHtml } from '@angular/platform-browser';

@Pipe({
  name: 'truncate'
})
export class TruncatePipe implements PipeTransform {
  constructor(private sanitizer: DomSanitizer) {}

  transform(value: any, limit: number): SafeHtml | string {
    if (value == null) return '';
    value = value.toString(); // ✅ correction : conversion en texte

    if (!limit || limit <= 0) return value; // ✅ correction : limite nulle → pas de troncature
    if (value.length <= limit) return value;

    const truncated = value.substr(0, limit) + '...';
    return this.sanitizer.bypassSecurityTrustHtml(truncated);
  }
}
