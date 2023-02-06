<div class="min-w-full overflow-hidden overflow-x-auto align-middle shadow sm:rounded-lg">
    <table class="min-w-full divide-y divide-m-blue">
        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody {{ $attributes }} class="bg-white divide-y divide-m-blue">
            {{ $body }}
        </tbody>
    </table>
</div>
