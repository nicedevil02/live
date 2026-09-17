{{-- اسکیمای استاندارد Service گوگل بدون ریتینگ --}}
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "{{ $name ?? $title ?? 'سامانه ابری تابلوی هوشمند طلالایو' }}",
  "serviceType": "{{ $serviceType ?? 'تابلو هوشمند طلافروشی و نمایشگر آنلاین نرخ طلا و ارز' }}",
  "description": "{{ $description ?? 'سامانه ابری هوشمند نمایش لحظه‌ای نرخ طلا، سکه و ارز روی تلویزیون بدون نیاز به کیس و سخت‌افزار اضافه.' }}",
  "url": "{{ $url ?? url()->current() }}",
  "provider": {
    "@@type": "Organization",
    "name": "طلالایو (TalaLive)",
    "url": "https://talalive.ir",
    "logo": "https://talalive.ir/images/logo.png"
  },
  "areaServed": {
    "@@type": "Country",
    "name": "Iran"
  },
  "offers": {
    "@@type": "Offer",
    "price": "0",
    "priceCurrency": "IRR",
    "name": "تست رایگان ۱۴ روزه بدون نیاز به پرداخت"
  }
}
</script>
