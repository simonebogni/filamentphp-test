<script type="text/javascript" src="{{ asset('/js/qr-code-styling.js') }}"></script>
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

    @php
        $imageUrl = $getImageUrl();
    @endphp
    <div
        x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }"
        x-init="
            const options = {
                width: {{ $getSize() }},
                height: {{ $getSize() }},
                type: 'svg',
                data: '{{$getRecord()->email}}',
                @if($imageUrl)
                    image: @js($imageUrl),
                    imageOptions: {
                        hideBackgroundDots: true,
                        imageSize: 50,
                        margin: 20,
                        crossOrigin: 'anonymous',
                    },
                @endif
                qrOptions: {
                    typeNumber: 0,
                    mode: 'Byte',
                    errorCorrectionLevel: 'H'
                },
                dotsOptions: {
                    color: '#4267b2',
                    type: 'dots'
                },
                cornersSquareOptions: {
                    color: '#4267b2',
                    type: 'dot',
                    // gradient: {
                    //   type: 'linear', // 'radial'
                    //   rotation: 180,
                    //   colorStops: [{ offset: 0, color: '#25456e' }, { offset: 1, color: '#4267b2' }]
                    // },
                },
                cornersDotOptions: {
                    color: '#4267b2',
                    type: 'dot',
                    // gradient: {
                    //   type: 'linear', // 'radial'
                    //   rotation: 180,
                    //   colorStops: [{ offset: 0, color: '#00266e' }, { offset: 1, color: '#4060b3' }]
                    // },
                }
{{--                backgroundOptions: {--}}
{{--                    color: '#e9ebee',--}}
{{--                },--}}
            }
            {{ $getStatePath() }} = new QRCodeStyling(options);
            {{ $getStatePath() }}.append($refs.canvas);
        "
    >
        <div id="qr" x-ref="canvas" @click="{{ $getStatePath() }}.download({ name: 'qr_code', extension: 'png' });"></div>
    </div>
    <script type="text/javascript">
        if(typeof data === typeof undefined) {
            data = {};
        }
        {{ $getStatePath() }} = null;
    </script>
</x-dynamic-component>
