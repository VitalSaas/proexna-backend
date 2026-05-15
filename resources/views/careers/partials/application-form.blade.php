@if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded mb-6">
        <p class="font-medium mb-1">Por favor revisa los siguientes datos:</p>
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo *</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico *</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
            <input type="text" name="city" id="city" value="{{ old('city') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>
    </div>

    @if(!empty($isOpen) && $isOpen)
    <div>
        <label for="position_interest" class="block text-sm font-medium text-gray-700 mb-1">Puesto o área de interés</label>
        <input type="text" name="position_interest" id="position_interest" value="{{ old('position_interest') }}"
               placeholder="Ej. Jardinería, diseño, mantenimiento..."
               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
    </div>
    @endif

    <div>
        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Cuéntanos sobre ti</label>
        <textarea name="message" id="message" rows="4"
                  placeholder="Experiencia, motivación, disponibilidad..."
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('message') }}</textarea>
    </div>

    <div>
        <label for="resume" class="block text-sm font-medium text-gray-700 mb-1">CV / Currículum (PDF, DOC, DOCX — máx. 5MB)</label>
        <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx"
               class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
    </div>

    <div class="text-xs text-gray-500">
        Al enviar este formulario aceptas que PROEXNA almacene y utilice tus datos para procesos de selección.
    </div>

    <div class="flex justify-center pt-2">
        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-10 rounded-lg transition-colors shadow-lg">
            Enviar Postulación
        </button>
    </div>
</form>
