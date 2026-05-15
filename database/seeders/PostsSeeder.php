<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Mantenimiento profesional de áreas verdes: claves para conservar jardines saludables',
                'slug' => 'mantenimiento-profesional-areas-verdes',
                'category' => 'mantenimiento',
                'author_name' => 'Equipo Técnico PROEXNA',
                'excerpt' => 'Un programa de mantenimiento bien planificado prolonga la vida útil de los jardines, reduce costos a largo plazo y conserva el valor estético de residencias y espacios comerciales. Compartimos los pilares que aplicamos en cada proyecto.',
                'published_at' => now()->subDays(14),
                'content' => <<<HTML
<p>El mantenimiento de un área verde no se reduce a podar el pasto o regar las plantas. Es una disciplina técnica que combina conocimientos de botánica, suelo, clima y planeación operativa. En PROEXNA hemos consolidado un protocolo basado en años de trabajo en residencias, oficinas y espacios públicos, y en este artículo compartimos los principios que lo sustentan.</p>

<h2>1. Diagnóstico inicial: la base de toda intervención</h2>
<p>Antes de proponer un plan de mantenimiento realizamos una evaluación integral del jardín. Identificamos las especies presentes, el estado fitosanitario, las condiciones del suelo (compactación, pH y nutrientes), la exposición solar y los sistemas de riego existentes. Este diagnóstico permite priorizar acciones y evitar tratamientos genéricos que muchas veces causan más daño que beneficio.</p>

<h2>2. Calendario estacional adaptado al clima local</h2>
<p>En Oaxaca, las temporadas seca y de lluvias marcan ritmos muy distintos. Un calendario profesional contempla:</p>
<ul>
    <li><strong>Temporada seca:</strong> riego controlado, mulching para conservar humedad, monitoreo de plagas oportunistas.</li>
    <li><strong>Inicio de lluvias:</strong> fertilización, poda de formación, control de maleza emergente.</li>
    <li><strong>Lluvias intensas:</strong> revisión de drenajes, prevención de enfermedades fúngicas, ajuste de tutores.</li>
    <li><strong>Post-lluvias:</strong> aireación, encalado si procede, replantación de zonas dañadas.</li>
</ul>

<h2>3. Poda técnica: la diferencia entre cortar y diseñar</h2>
<p>Una poda mal ejecutada puede comprometer la salud del árbol o arbusto por años. Aplicamos los principios de poda de formación, mantenimiento y sanitaria respetando los tiempos biológicos de cada especie. Nunca utilizamos selladores genéricos sobre cortes grandes: la cicatrización natural, cuando el corte se realiza correctamente, es más efectiva.</p>

<h2>4. Manejo integrado de plagas (MIP)</h2>
<p>Antes de aplicar cualquier producto fitosanitario evaluamos si la presencia de un organismo realmente está causando daño económico o estético significativo. Priorizamos el control biológico, las trampas y los métodos físicos. Los agroquímicos son el último recurso, no el primero.</p>

<h2>5. Documentación y trazabilidad</h2>
<p>Cada visita de mantenimiento queda documentada: actividades realizadas, productos aplicados, observaciones del estado del jardín y recomendaciones para la siguiente visita. Esto permite al cliente ver la evolución de su espacio y nos da insumos para ajustar el plan.</p>

<h3>¿Por qué invertir en mantenimiento profesional?</h3>
<p>Un jardín bien mantenido puede aumentar entre un 5% y un 15% el valor percibido de una propiedad, reduce la necesidad de reemplazos costosos de plantas y crea ambientes que favorecen el bienestar de quienes los habitan. Pero más allá del retorno económico, hablamos de cuidar seres vivos que aportan oxígeno, regulan la temperatura y embellecen nuestro entorno.</p>

<p>Si te interesa que evaluemos tu espacio y construyamos un plan de mantenimiento a la medida, <a href="/contacto">contáctanos</a> para agendar una visita técnica.</p>
HTML,
            ],
            [
                'title' => 'Riego eficiente: cómo reducir el consumo de agua sin sacrificar la vitalidad del jardín',
                'slug' => 'riego-eficiente-reducir-consumo-agua',
                'category' => 'consejos',
                'author_name' => 'Equipo Técnico PROEXNA',
                'excerpt' => 'El riego representa hasta el 60% del consumo de agua en residencias con jardín. Diseñar un sistema eficiente no solo beneficia al planeta y al bolsillo: produce plantas más sanas y resistentes. Te explicamos cómo lograrlo.',
                'published_at' => now()->subDays(7),
                'content' => <<<HTML
<p>El agua es uno de los recursos más comprometidos en la actualidad. En zonas como el Valle de Oaxaca, donde la disponibilidad hídrica varía drásticamente entre estaciones, regar bien no es un lujo: es una responsabilidad ambiental y económica. Un sistema de riego mal diseñado puede desperdiciar miles de litros al mes y, paradójicamente, debilitar las plantas que pretende cuidar.</p>

<h2>El error más común: regar demasiado y muy seguido</h2>
<p>Riegos frecuentes y superficiales obligan a las raíces a quedarse en los primeros centímetros del suelo, donde son vulnerables a la sequía. En cambio, riegos menos frecuentes pero más profundos invitan a las raíces a explorar hacia abajo, generando plantas más resistentes y autónomas.</p>

<h2>Tecnologías que recomendamos</h2>

<h3>Riego por goteo</h3>
<p>Entrega el agua directamente en la zona radicular, con pérdidas por evaporación mínimas. Es ideal para arbustos, árboles y huertas. Bien instalado, puede ahorrar hasta un 50% de agua frente a la aspersión convencional.</p>

<h3>Programadores inteligentes con sensor de humedad</h3>
<p>Los controladores modernos se sincronizan con datos meteorológicos locales y suspenden el riego cuando hay lluvia o exceso de humedad en el suelo. La inversión inicial se recupera en una o dos temporadas.</p>

<h3>Aspersión de precisión</h3>
<p>Para áreas de pasto, los aspersores de bajo caudal y trayectoria ajustable evitan el desperdicio sobre banquetas o muros. Los antiguos aspersores giratorios sin ajuste son una de las principales causas de fuga invisible.</p>

<h2>Buenas prácticas que aplicamos en cada proyecto</h2>
<ul>
    <li><strong>Riego nocturno o muy temprano:</strong> evita pérdidas por evaporación y reduce el riesgo de enfermedades foliares.</li>
    <li><strong>Mulching o acolchado:</strong> una capa de corteza, hojarasca o composta sobre el suelo conserva la humedad y regula la temperatura radicular.</li>
    <li><strong>Agrupar plantas por necesidad hídrica (hidrozonificación):</strong> diseñar el jardín en zonas con requerimientos similares evita sobreriego en unas y subriego en otras.</li>
    <li><strong>Mantenimiento periódico del sistema:</strong> goteros tapados, fugas en juntas o boquillas dañadas pueden duplicar el consumo sin que se note.</li>
</ul>

<h2>Plantas que toleran mejor la sequía</h2>
<p>Una estrategia complementaria es incorporar especies adaptadas al clima local. Algunas que recomendamos para Oaxaca incluyen:</p>
<ul>
    <li>Agaves y suculentas nativas</li>
    <li>Lavanda y romero</li>
    <li>Bugambilia (florece más con poco riego)</li>
    <li>Pasto buffel o gramíneas ornamentales</li>
    <li>Árboles como huizache, mezquite o palo de Brasil</li>
</ul>

<h3>El balance ideal</h3>
<p>Un buen sistema de riego no busca usar la menor cantidad posible de agua, sino entregar exactamente la cantidad correcta en el momento y lugar correctos. Esa precisión se traduce en plantas más sanas, facturas más bajas y un impacto ambiental menor.</p>

<p>Si quieres una evaluación del sistema actual de tu jardín o un diseño nuevo de riego eficiente, escríbenos. Realizamos auditorías hídricas y proyectos integrales.</p>
HTML,
            ],
            [
                'title' => 'Diseño de jardines sustentables: principios para climas como el de Oaxaca',
                'slug' => 'diseno-jardines-sustentables-oaxaca',
                'category' => 'sustentabilidad',
                'author_name' => 'Equipo de Diseño PROEXNA',
                'excerpt' => 'Un jardín sustentable no es solo ecológico: es un espacio que se adapta al clima, requiere menos insumos y se vuelve más bello con el tiempo. Compartimos los principios de diseño que aplicamos en nuestros proyectos.',
                'published_at' => now()->subDays(2),
                'content' => <<<HTML
<p>El concepto de sustentabilidad en jardinería ha evolucionado mucho en la última década. Ya no basta con "usar plantas nativas" o "no aplicar químicos". Un jardín verdaderamente sustentable se diseña con una visión sistémica: agua, suelo, biodiversidad, mantenimiento futuro y uso humano se piensan como un todo desde la primera línea del plano.</p>

<h2>Los cinco principios que guían nuestro trabajo</h2>

<h3>1. Diseño basado en el sitio (site-responsive design)</h3>
<p>Cada terreno tiene una orientación, pendiente, tipo de suelo y microclima únicos. Antes de proponer cualquier especie estudiamos cómo se comporta el sol durante el día, dónde se acumula la humedad, qué vientos predominan. El diseño se adapta al lugar, no al revés.</p>

<h3>2. Selección de especies adaptadas</h3>
<p>Privilegiamos especies nativas o naturalizadas que prosperan sin riego excesivo ni cuidados intensivos. En Oaxaca contamos con una biodiversidad extraordinaria: agaves, copales, jacarandas, bugambilias, salvias, hierba del sapo, entre muchas otras. Diseñar con lo que ya pertenece al lugar es la decisión más sustentable que puede tomarse.</p>

<h3>3. Gestión inteligente del agua</h3>
<p>Integramos sistemas de captación de agua pluvial, jardines de lluvia para infiltración, hidrozonificación y riego por goteo desde la etapa de diseño. Un jardín bien planeado puede operar con una fracción del agua que consumiría un jardín convencional del mismo tamaño.</p>

<h3>4. Suelos vivos</h3>
<p>El suelo no es un soporte inerte: es un ecosistema. Promovemos la incorporación de composta, mulching constante y, cuando aplica, micorrizas. Un suelo sano nutre a las plantas y reduce dramáticamente la necesidad de fertilizantes sintéticos.</p>

<h3>5. Biodiversidad funcional</h3>
<p>Diseñamos para atraer polinizadores, aves y fauna benéfica. Esto no es decorativo: los enemigos naturales de las plagas reducen la necesidad de pesticidas, y un ecosistema diverso es más resiliente ante eventos climáticos o brotes.</p>

<h2>Errores comunes que evitamos</h2>
<ul>
    <li><strong>Importar diseños de climas distintos:</strong> un jardín inglés en clima semiárido se convierte en un sumidero de agua y mantenimiento.</li>
    <li><strong>Plantar sin pensar en el crecimiento futuro:</strong> árboles muy juntos terminan compitiendo y enfermándose.</li>
    <li><strong>Excederse con pasto:</strong> el césped es el elemento de jardín más demandante en agua y mantenimiento. Reducir su superficie a las zonas funcionales es una decisión inteligente.</li>
    <li><strong>Olvidar el mantenimiento como parte del diseño:</strong> un jardín que requiere más cuidados de los que el cliente puede sostener nunca se verá bien.</li>
</ul>

<h2>El retorno de un jardín sustentable</h2>
<p>Más allá del beneficio ambiental, un diseño sustentable bien ejecutado reduce significativamente los costos operativos a largo plazo: menos agua, menos fertilizantes, menos plagas, menos reemplazos. Además, crea espacios que evolucionan favorablemente con el tiempo, en lugar de degradarse.</p>

<h3>Cada proyecto es único</h3>
<p>No existe una receta universal. Un jardín residencial pequeño, una azotea verde, un parque corporativo o una hacienda requieren enfoques distintos. Lo que sí es transversal es el método: observar, diseñar con el sitio, elegir bien y planear el largo plazo.</p>

<p>Si tienes un proyecto en mente y te interesa explorar un enfoque sustentable, agendemos una visita. Hacemos diagnósticos y propuestas conceptuales sin costo en el área de Oaxaca.</p>
HTML,
            ],
            [
                'title' => 'Plantas nativas de Oaxaca para tu jardín: belleza con identidad y bajo mantenimiento',
                'slug' => 'plantas-nativas-oaxaca-jardin',
                'category' => 'plantas',
                'author_name' => 'Equipo de Diseño PROEXNA',
                'excerpt' => 'La flora nativa de Oaxaca ofrece especies espectaculares, adaptadas al clima y resistentes a plagas locales. Una guía práctica para integrarlas en jardines residenciales y comerciales.',
                'published_at' => now()->subDays(30),
                'content' => <<<HTML
<p>Oaxaca es uno de los estados con mayor biodiversidad vegetal de México. Esa riqueza no solo es patrimonio natural: es una caja de herramientas para diseñar jardines hermosos, resilientes y profundamente vinculados al territorio. Sin embargo, en la mayoría de los jardines particulares siguen dominando especies importadas que requieren más agua, más fertilizante y más cuidados de los necesarios.</p>

<h2>¿Por qué elegir plantas nativas?</h2>
<ul>
    <li><strong>Adaptación natural:</strong> evolucionaron en este clima y suelo, por lo que prosperan con riego mínimo una vez establecidas.</li>
    <li><strong>Resistencia a plagas locales:</strong> coexisten con la fauna y los hongos de la región y suelen tolerarlos sin colapsar.</li>
    <li><strong>Polinizadores y biodiversidad:</strong> atraen abejas, colibríes y mariposas locales, generando ecosistemas vivos.</li>
    <li><strong>Identidad cultural:</strong> tu jardín se ve "de Oaxaca", no de cualquier ciudad genérica.</li>
</ul>

<h2>Especies que recomendamos integrar</h2>

<h3>Agave potatorum y Agave karwinskii</h3>
<p>Esculturales, longevas y prácticamente libres de mantenimiento. Funcionan como punto focal o en composiciones de bajo riego.</p>

<h3>Copal (Bursera spp.)</h3>
<p>Árboles aromáticos de copa ligera, ideales para climas cálidos. Su fragancia y corteza atractiva añaden carácter al espacio.</p>

<h3>Bugambilia (Bougainvillea spp.)</h3>
<p>Aunque no es estrictamente endémica, está naturalizada hace siglos. Florece con poco riego y aporta color durante meses.</p>

<h3>Cazahuate (Ipomoea arborescens)</h3>
<p>Árbol pequeño con floración blanca espectacular en temporada seca. Tolera suelos pobres.</p>

<h3>Salvia mexicana</h3>
<p>Arbusto floral con espigas azul violáceo que atrae colibríes. Florece varias veces al año con poda ligera.</p>

<h2>Cómo integrar plantas nativas en un jardín existente</h2>
<p>No es necesario rehacer todo el jardín. Recomendamos una transición gradual:</p>
<ol>
    <li>Identifica las zonas con mayor consumo de agua o más problemas de plagas.</li>
    <li>Reemplaza esas zonas con composiciones nativas adaptadas a la exposición solar.</li>
    <li>Conserva las plantas existentes que funcionan bien y combínalas con las nuevas.</li>
    <li>Documenta el comportamiento durante el primer año para ajustar.</li>
</ol>

<p>Si quieres explorar un diseño con flora nativa para tu espacio, podemos visitarlo y proponerte una composición a la medida.</p>
HTML,
            ],
            [
                'title' => 'Invasión de hongos en pasto: cómo identificarla y tratarla profesionalmente',
                'slug' => 'invasion-hongos-pasto-identificar-tratar',
                'category' => 'mantenimiento',
                'author_name' => 'Equipo Técnico PROEXNA',
                'excerpt' => 'Manchas amarillas, círculos secos o moho blanquecino son señales de un problema fúngico que puede destruir un pasto en semanas. Te explicamos los tipos más comunes y cómo enfrentarlos.',
                'published_at' => now()->subDays(25),
                'content' => <<<HTML
<p>La invasión de hongos en pasto es uno de los problemas más frecuentes (y peor diagnosticados) en jardines residenciales y áreas verdes comerciales. Muchas veces se atribuye a "falta de agua" o "exceso de sol", cuando la causa real es una infección fúngica que requiere tratamiento específico. En PROEXNA llevamos años especializándonos en este tipo de tratamientos y queremos compartir los patrones más comunes.</p>

<h2>Señales de alerta temprana</h2>
<ul>
    <li>Manchas circulares amarillentas o marrones de bordes definidos</li>
    <li>Pelusilla blanca, gris o rosada visible al amanecer cuando hay rocío</li>
    <li>Áreas que no rebrotan después de regar o fertilizar</li>
    <li>Olor a humedad o "moho" al caminar sobre el pasto</li>
    <li>Hojas con manchas pequeñas concentradas en una zona</li>
</ul>

<h2>Hongos más comunes en climas como el de Oaxaca</h2>

<h3>Mancha foliar (Helminthosporium)</h3>
<p>Aparece en hojas como pequeñas manchas marrones con halo amarillo. Se acelera con riegos nocturnos y exceso de fertilizante nitrogenado.</p>

<h3>Pythium (damping-off)</h3>
<p>Letal y rápido: el pasto se vuelve aceitoso, oscuro y muere en parches en menos de una semana. Prospera con suelos saturados de agua y temperaturas cálidas.</p>

<h3>Rhizoctonia (brown patch)</h3>
<p>Crea círculos marrones de hasta un metro de diámetro. El interior puede recuperarse, dando aspecto de "anillos".</p>

<h3>Roya (Puccinia)</h3>
<p>Polvillo anaranjado o amarillento que se desprende al tocar el pasto. Mancha la ropa y los zapatos. Indica estrés y baja fertilización.</p>

<h2>Por qué no funciona "rociar fungicida y ya"</h2>
<p>Aplicar un fungicida sin identificar el hongo es como tomar antibióticos sin saber si tienes una infección bacteriana. Muchos fungicidas son específicos: el que funciona para Pythium no sirve contra Rhizoctonia. Por eso siempre realizamos un diagnóstico previo —visual y, cuando es necesario, de laboratorio— antes de definir el tratamiento.</p>

<h2>Protocolo de tratamiento profesional</h2>
<ol>
    <li><strong>Diagnóstico:</strong> inspección visual y muestreo si la sintomatología no es clara.</li>
    <li><strong>Corrección de condiciones predisponentes:</strong> ajustar frecuencia y horario de riego, aireación del suelo, drenaje.</li>
    <li><strong>Aplicación dirigida:</strong> fungicida específico, sistémico o de contacto según el caso.</li>
    <li><strong>Refuerzo nutricional:</strong> fertilización balanceada para acelerar la recuperación del pasto sobreviviente.</li>
    <li><strong>Resiembra de zonas perdidas:</strong> una vez controlado el foco, repoblamos con semilla o tepe.</li>
    <li><strong>Monitoreo posterior:</strong> visitas de seguimiento durante el ciclo crítico.</li>
</ol>

<h2>Prevención: la mejor inversión</h2>
<p>Más del 70% de los problemas fúngicos se previenen ajustando el riego (mañana temprano, no de noche), evitando el exceso de nitrógeno, manteniendo buena aireación del suelo y haciendo cortes a la altura correcta. Un plan de mantenimiento profesional contempla todos estos factores.</p>

<p>Si detectaste alguna de las señales descritas, no esperes a que el problema se extienda. <a href="/contacto">Solicita una evaluación</a> y atendemos en menos de 48 horas.</p>
HTML,
            ],
            [
                'title' => 'Paisajismo corporativo: jardines que comunican los valores de tu empresa',
                'slug' => 'paisajismo-corporativo-jardines-comunican',
                'category' => 'paisajismo',
                'author_name' => 'Equipo de Diseño PROEXNA',
                'excerpt' => 'Los espacios verdes corporativos influyen en la percepción de marca, la productividad del equipo y la experiencia del cliente. Una mirada estratégica al paisajismo en oficinas, hoteles y comercios.',
                'published_at' => now()->subDays(21),
                'content' => <<<HTML
<p>Cuando un cliente entra a tu empresa, antes de leer una palabra ya formó una primera impresión. La fachada, el acceso, los jardines y las áreas comunes comunican tanto como cualquier campaña de marketing. El paisajismo corporativo no es un lujo decorativo: es una inversión estratégica que se refleja en imagen, retención de talento y experiencia del usuario.</p>

<h2>Tres dimensiones del paisajismo corporativo</h2>

<h3>1. Imagen y marca</h3>
<p>Un acceso bien diseñado refuerza el posicionamiento que la empresa quiere proyectar. Una firma legal sobria comunica solidez con jardines geométricos y especies arbustivas; una marca creativa puede arriesgar con paletas de color, texturas y composiciones más libres. El paisajismo debe ser una extensión de la identidad visual.</p>

<h3>2. Bienestar del equipo interno</h3>
<p>Numerosos estudios documentan que los espacios verdes reducen estrés, mejoran la concentración y disminuyen el ausentismo. Patios interiores, jardines comestibles, terrazas verdes y vistas hacia áreas vegetales no son detalles menores: son herramientas de productividad.</p>

<h3>3. Experiencia del cliente</h3>
<p>En hoteles, restaurantes, hospitales o centros comerciales, el jardín forma parte de la experiencia. Una llegada agradable, sombra natural, sonido de agua o aroma de plantas crea recuerdo y diferenciación.</p>

<h2>Errores frecuentes en paisajismo corporativo</h2>
<ul>
    <li><strong>Subestimar el mantenimiento:</strong> diseñar jardines que la empresa luego no puede sostener termina dando peor imagen que no tenerlos.</li>
    <li><strong>Plantar al "todos los lugares se ven igual":</strong> ignorar el clima, la identidad regional y el contexto.</li>
    <li><strong>Sobrecargar de elementos decorativos:</strong> rocas, fuentes y luces en exceso saturan la lectura del espacio.</li>
    <li><strong>Olvidar la escala humana:</strong> jardines pensados solo para vista aérea o desde el edificio, sin experiencia a nivel peatón.</li>
</ul>

<h2>Lo que recomendamos a nuestros clientes corporativos</h2>
<ol>
    <li>Diagnóstico de identidad y objetivos: ¿qué quieres comunicar?</li>
    <li>Análisis del sitio: orientación, vientos, tránsito, vistas clave.</li>
    <li>Anteproyecto con plan de mantenimiento incluido desde el inicio.</li>
    <li>Selección de especies adaptadas y de bajo consumo de recursos.</li>
    <li>Programa anual de cuidados documentado y entregado al cliente.</li>
</ol>

<h2>Casos donde el paisajismo cambió el negocio</h2>
<p>Hemos trabajado con hoteles boutique cuyos patios interiores se volvieron icónicos en redes sociales, con oficinas donde los empleados empezaron a usar la terraza para reuniones y con desarrollos residenciales cuya plusvalía subió cuando se mejoraron las áreas comunes. El retorno de inversión del paisajismo corporativo, cuando se hace bien, es medible.</p>

<p>Si estás evaluando renovar las áreas verdes de tu empresa o lanzar un proyecto nuevo, podemos realizar un diagnóstico inicial sin costo en el área de Oaxaca.</p>
HTML,
            ],
            [
                'title' => 'Cinco plantas resistentes para jardines con poca luz',
                'slug' => 'plantas-poca-luz-jardin-sombra',
                'category' => 'plantas',
                'author_name' => 'Equipo Técnico PROEXNA',
                'excerpt' => 'Patios interiores, balcones con orientación norte o rincones bajo árboles densos no tienen que verse vacíos. Compartimos cinco especies que prosperan con luz indirecta y poco mantenimiento.',
                'published_at' => now()->subDays(18),
                'content' => <<<HTML
<p>Una de las consultas más frecuentes que recibimos es qué plantar en zonas del jardín que reciben poca luz directa. La buena noticia es que existen muchas especies que evolucionaron precisamente en condiciones de sombra y prosperan en ese ambiente. Acá nuestras cinco favoritas para climas como el de Oaxaca.</p>

<h2>1. Helechos espada (Nephrolepis exaltata)</h2>
<p>Clásico por una buena razón: tolera sombra densa, humedad ambiental moderada y crece formando matas frondosas. Ideal para patios interiores y zonas bajo techo. Requiere riego moderado y evitar el sol directo del mediodía.</p>

<h2>2. Cuna de Moisés (Spathiphyllum)</h2>
<p>Flores blancas elegantes que aparecen varias veces al año, hojas verde brillante. Soporta luz baja y es una de las plantas más eficientes para filtrar contaminantes del aire según estudios de NASA.</p>

<h2>3. Anturio (Anthurium andraeanum)</h2>
<p>Sus "flores" cerosas en rojo, blanco o rosa duran semanas. Aunque necesita luz indirecta brillante, no soporta el sol directo. Riego regular sin encharcar.</p>

<h2>4. Costilla de Adán (Monstera deliciosa)</h2>
<p>Su crecimiento exuberante y hojas perforadas la han vuelto icónica. Tolera bien la sombra y crece tanto en maceta como trepando por una pared interior. Atención: sus hojas son tóxicas para mascotas.</p>

<h2>5. Drácena (Dracaena fragrans)</h2>
<p>Aporta verticalidad y estructura. Sobrevive en condiciones de luz baja durante meses sin perder vigor. Riego espaciado: tolera mejor la sequía que el exceso.</p>

<h2>Tips para jardines de sombra exitosos</h2>
<ul>
    <li><strong>No confundir sombra con humedad:</strong> muchas zonas sombreadas son secas. Conoce las necesidades reales de cada especie.</li>
    <li><strong>Pisos con texturas:</strong> piedras, grava, mulching o cobertores vivos compensan la falta de flores intensas.</li>
    <li><strong>Aprovechar el verde como protagonista:</strong> en zonas con poca luz, las hojas variegadas (con franjas blancas o amarillas) iluminan visualmente.</li>
    <li><strong>Iluminación nocturna cálida:</strong> realza texturas y permite disfrutar el espacio cuando hay menos luz natural.</li>
</ul>

<p>Si tienes una zona de tu jardín que nunca lograste hacer funcionar, escríbenos. Visitamos el lugar y te proponemos una composición específica.</p>
HTML,
            ],
            [
                'title' => 'Muros verdes: cómo transformar paredes en jardines vivos',
                'slug' => 'muros-verdes-paredes-vivas',
                'category' => 'diseno',
                'author_name' => 'Equipo de Diseño PROEXNA',
                'excerpt' => 'Los muros verdes resuelven problemas estéticos, regulan temperatura y aprovechan superficies subutilizadas. Te explicamos los tipos, costos y consideraciones para hacerlos perdurar.',
                'published_at' => now()->subDays(15),
                'content' => <<<HTML
<p>Los muros verdes pasaron de ser una curiosidad arquitectónica a convertirse en una solución integral para problemas de espacio, temperatura y estética en proyectos residenciales y comerciales. Pero también son una de las inversiones que más fallan cuando se hacen sin planeación. En este artículo compartimos lo que aprendimos en años instalando y manteniendo este tipo de sistemas.</p>

<h2>Tipos de muros verdes</h2>

<h3>1. Muros con enredaderas tradicionales</h3>
<p>El sistema más simple y económico: enredaderas plantadas en piso que trepan por estructura de cables o rejillas. Especies como buganvilia, jazmín, hiedra o pasionarias funcionan bien. Tarda más en cubrir, pero el mantenimiento es bajo.</p>

<h3>2. Sistemas modulares con sustrato</h3>
<p>Paneles prefabricados con macetas o bolsillos, montados sobre la pared con riego automatizado integrado. Cobertura rápida (3-6 meses), gran variedad de especies. Requiere inversión inicial mayor y mantenimiento técnico constante.</p>

<h3>3. Sistemas hidropónicos verticales</h3>
<p>Las raíces se desarrollan sobre fieltro o sustrato mínimo, alimentadas por solución nutritiva en circuito cerrado. Es el sistema más espectacular y técnico, ideal para interiores corporativos o vestíbulos premium.</p>

<h2>Beneficios reales (medibles)</h2>
<ul>
    <li><strong>Reducción de temperatura:</strong> un muro verde bien ejecutado puede disminuir hasta 5°C la superficie del muro y 2-3°C el ambiente cercano.</li>
    <li><strong>Aislamiento acústico:</strong> reduce el ruido externo entre 5 y 10 decibelios.</li>
    <li><strong>Filtración de partículas:</strong> las hojas capturan polvo y contaminantes.</li>
    <li><strong>Aprovechamiento de espacio:</strong> jardín sin sacrificar metros cuadrados de piso.</li>
    <li><strong>Impacto visual:</strong> diferenciador inmediato de cualquier espacio.</li>
</ul>

<h2>Lo que normalmente sale mal</h2>
<ol>
    <li><strong>Riego mal calculado:</strong> demasiado o muy poco. Los muros verdes exigen riego de precisión, casi siempre automatizado.</li>
    <li><strong>Especies inadecuadas para la orientación:</strong> plantar especies de sombra en muro al sur (o viceversa) garantiza fracaso.</li>
    <li><strong>Drenaje deficiente:</strong> agua estancada en la base mancha pisos y pudre raíces.</li>
    <li><strong>Mantenimiento intermitente:</strong> los muros verdes requieren visitas técnicas mensuales como mínimo.</li>
    <li><strong>Estructura subdimensionada:</strong> un muro con riego y sustrato pesa varios kilos por metro cuadrado.</li>
</ol>

<h2>Cuánto cuesta y cuánto dura</h2>
<p>Los costos varían enormemente según el sistema, pero como referencia: un muro con enredaderas tradicionales puede costar entre $300 y $800 MXN por m² instalado; un sistema modular oscila entre $3,500 y $7,000 MXN por m² con riego automatizado. Con mantenimiento profesional, un muro verde bien instalado dura más de 10 años, renovando especies cuando es necesario.</p>

<p>Si te interesa explorar la viabilidad de un muro verde en tu espacio, contáctanos. Hacemos diagnósticos sin costo y proyectos con garantía de instalación.</p>
HTML,
            ],
            [
                'title' => 'PROEXNA participa en jornada de reforestación comunitaria en Etla',
                'slug' => 'proexna-reforestacion-comunitaria-etla',
                'category' => 'noticias',
                'author_name' => 'Comunicación PROEXNA',
                'excerpt' => 'Junto al H. Ayuntamiento de San Agustín Etla y voluntarios locales, plantamos más de 350 árboles nativos en zonas degradadas del municipio. Una jornada que combina técnica, comunidad y compromiso ambiental.',
                'published_at' => now()->subDays(10),
                'content' => <<<HTML
<p>El pasado fin de semana, el equipo de PROEXNA participó como aliado técnico en una jornada de reforestación comunitaria en San Agustín Etla. La actividad, organizada por el H. Ayuntamiento y diversos colectivos vecinales, reunió a más de 120 voluntarios y permitió la siembra de más de 350 árboles nativos en zonas afectadas por erosión y pérdida de cobertura vegetal.</p>

<h2>Especies seleccionadas</h2>
<p>La selección de especies fue resultado de un trabajo previo con la dirección de Ecología del municipio. Se priorizaron árboles nativos del Valle de Oaxaca con alto valor ecológico y resistencia al clima local:</p>
<ul>
    <li>Encino (Quercus spp.)</li>
    <li>Fresno (Fraxinus uhdei)</li>
    <li>Jacaranda (Jacaranda mimosifolia)</li>
    <li>Tepehuaje (Lysiloma acapulcense)</li>
    <li>Huizache (Vachellia farnesiana)</li>
</ul>

<h2>Más que plantar: garantizar la sobrevivencia</h2>
<p>Una de las críticas comunes a las jornadas de reforestación masiva es que muchos árboles mueren en los primeros meses por falta de seguimiento. Por eso, nuestro aporte no se limitó al día del evento. Antes de la jornada capacitamos al equipo municipal y voluntarios en:</p>
<ul>
    <li>Técnicas correctas de plantado (profundidad, ubicación del cuello, compactación adecuada).</li>
    <li>Diseño de microcuencas para captar agua de lluvia y reducir el estrés hídrico inicial.</li>
    <li>Calendario de riego de auxilio durante los primeros seis meses.</li>
    <li>Identificación temprana de plagas y enfermedades comunes.</li>
</ul>

<p>Además, donamos parte del material vegetal y nos comprometimos a realizar visitas técnicas de monitoreo durante el primer año, sin costo para el municipio.</p>

<h2>Por qué nos involucramos</h2>
<p>En PROEXNA creemos que el conocimiento técnico debe estar al servicio de la comunidad, no solo de los proyectos privados. Las áreas verdes públicas son tan importantes como cualquier jardín residencial: regulan temperatura, generan identidad y crean espacios de convivencia. Apoyar proyectos como este forma parte de nuestra forma de entender la profesión.</p>

<h2>Próximos pasos</h2>
<p>El convenio con el municipio contempla una segunda jornada en la temporada de lluvias del próximo año, así como talleres de educación ambiental para escuelas primarias de la zona. Quienes deseen sumarse como voluntarios o donantes pueden escribirnos a través del <a href="/contacto">formulario de contacto</a>.</p>

<p>Agradecemos al H. Ayuntamiento de San Agustín Etla, a los colectivos participantes y a cada voluntario que dedicó su sábado a sembrar futuro.</p>
HTML,
            ],
            [
                'title' => 'Compostaje doméstico: cómo convertir residuos orgánicos en oro vegetal',
                'slug' => 'compostaje-domestico-residuos-organicos',
                'category' => 'sustentabilidad',
                'author_name' => 'Equipo Técnico PROEXNA',
                'excerpt' => 'Hasta un 40% de la basura doméstica son residuos orgánicos que pueden transformarse en composta de excelente calidad. Una guía práctica para hacerlo en casa, sin malos olores ni complicaciones.',
                'published_at' => now()->subDays(6),
                'content' => <<<HTML
<p>El compostaje es probablemente la forma más simple y efectiva de cerrar el ciclo de los nutrientes en un hogar. Cáscaras de frutas, restos de poda, hojas secas o residuos del café se transforman, en pocas semanas, en un fertilizante natural superior a casi cualquier producto comercial. Y todo sucede sin energía adicional, en un rincón discreto del jardín.</p>

<h2>Qué se puede compostar</h2>
<h3>Materiales verdes (ricos en nitrógeno)</h3>
<ul>
    <li>Cáscaras y restos de frutas y verduras</li>
    <li>Posos de café y bolsas de té (sin grapa)</li>
    <li>Pasto recién cortado</li>
    <li>Restos de poda fresca</li>
</ul>

<h3>Materiales secos (ricos en carbono)</h3>
<ul>
    <li>Hojas secas</li>
    <li>Cartón sin tintas y papel sin brillo</li>
    <li>Aserrín de maderas no tratadas</li>
    <li>Ramitas y poda seca triturada</li>
</ul>

<h2>Qué NO se debe compostar</h2>
<ul>
    <li>Carne, pescado, huesos (atraen plagas y generan olores)</li>
    <li>Lácteos y aceites</li>
    <li>Heces de mascotas carnívoras</li>
    <li>Plantas enfermas o con hongos</li>
    <li>Cenizas de carbón mineral o cigarro</li>
</ul>

<h2>La regla de oro: equilibrio verde-seco</h2>
<p>Una composta exitosa equilibra aproximadamente <strong>1 parte de material verde por cada 2 o 3 partes de material seco</strong>. El exceso de verdes genera olor y compactación; el exceso de secos hace que el proceso se ralentice. Cuando agregues cáscaras o restos frescos, cubre siempre con hojas secas o cartón triturado.</p>

<h2>Pasos para empezar hoy</h2>
<ol>
    <li><strong>Elige el contenedor:</strong> puede ser una compostera comercial, un cajón de madera o simplemente un montón en una esquina sombreada.</li>
    <li><strong>Base de drenaje:</strong> empieza con una capa de ramitas trituradas para permitir aireación.</li>
    <li><strong>Alterna capas:</strong> verde, seco, verde, seco.</li>
    <li><strong>Mantén humedad:</strong> debe sentirse como esponja exprimida; ni encharcada ni seca.</li>
    <li><strong>Voltea cada 2-3 semanas:</strong> esto inyecta oxígeno y acelera el proceso.</li>
    <li><strong>Cosecha:</strong> en 2 a 4 meses tendrás composta lista en el fondo del contenedor.</li>
</ol>

<h2>Cómo saber que está lista</h2>
<p>La composta madura tiene color marrón oscuro, textura suelta y olor a tierra de bosque. No deben reconocerse los materiales originales. Si todavía ves cáscaras o estructuras vegetales, déjala madurar más.</p>

<h2>Cómo usarla</h2>
<ul>
    <li><strong>Como abono superficial:</strong> 2-3 cm alrededor de plantas, sin tocar el tallo.</li>
    <li><strong>En siembras nuevas:</strong> mezclada con tierra al 30%.</li>
    <li><strong>Como té de composta:</strong> remojada en agua durante 24 horas, filtrada y usada como fertilizante líquido.</li>
</ul>

<p>El compostaje doméstico reduce significativamente la basura que sale de tu casa y crea un recurso valioso para tu jardín. Si quieres asesoría para montar un sistema de compostaje en tu casa o empresa, podemos ayudarte a diseñarlo a la medida.</p>
HTML,
            ],
            [
                'title' => 'Tendencias 2026 en jardinería y paisajismo profesional',
                'slug' => 'tendencias-jardineria-paisajismo-2026',
                'category' => 'paisajismo',
                'author_name' => 'Equipo de Diseño PROEXNA',
                'excerpt' => 'Jardines comestibles, biodiversidad funcional, resiliencia climática y diseño biofílico marcan la agenda del 2026. Repasamos las tendencias que sí valen la pena adoptar.',
                'published_at' => now()->subDays(2),
                'content' => <<<HTML
<p>El mundo del paisajismo está cambiando rápido. Las exigencias ambientales, los nuevos hábitos de uso del espacio exterior y la mayor conciencia sobre biodiversidad están moldeando una forma de diseñar muy distinta a la de hace una década. En este artículo repasamos las tendencias del 2026 que consideramos sustanciales y no solo modas estéticas.</p>

<h2>1. Jardines comestibles integrados</h2>
<p>La separación entre "huerto" y "jardín ornamental" se está disolviendo. Hierbas aromáticas, frutales enanos, hortalizas de hoja y flores comestibles conviven con plantas ornamentales tradicionales, sin sacrificar estética. En proyectos residenciales y restauranteros, este enfoque convierte al jardín en una despensa viva.</p>

<h2>2. Biodiversidad funcional</h2>
<p>Diseñar para atraer polinizadores, controladores naturales de plagas y aves locales ya no es solo una declaración ambiental: es una herramienta práctica que reduce la necesidad de pesticidas. Veremos más jardines con "zonas refugio" deliberadas: piedras apiladas, troncos, plantas silvestres conservadas.</p>

<h2>3. Diseño biofílico en espacios interiores</h2>
<p>Llevar el jardín adentro a través de muros verdes, plantas estructurales y materiales naturales se consolida como estándar en oficinas, hoteles y residencias premium. La evidencia sobre su impacto en bienestar y productividad ya es contundente.</p>

<h2>4. Resiliencia climática</h2>
<p>Diseños capaces de soportar eventos extremos —sequías prolongadas, lluvias torrenciales, olas de calor— sin colapsar. Esto implica selección de especies tolerantes, sistemas de drenaje sobredimensionados, captación de agua pluvial y suelos vivos profundos.</p>

<h2>5. Paletas cromáticas naturalistas</h2>
<p>El verde monocromático y los jardines geométricos rígidos están cediendo terreno frente a composiciones con texturas mixtas, gramíneas ornamentales, floraciones estacionales y paletas que evocan paisajes silvestres. El diseño "naturalista controlado" requiere más oficio del que aparenta.</p>

<h2>6. Tecnología discreta</h2>
<p>Sensores de humedad, programadores con datos meteorológicos, iluminación con sensores de presencia: la tecnología en el jardín avanza, pero la tendencia es a hacerla invisible. La buena tecnología en paisajismo no se nota; solo se nota cuando falta.</p>

<h2>7. Materiales locales y bajo impacto</h2>
<p>Cantera de la región, madera certificada local, gravas naturales en lugar de concretos. Tanto por estética como por huella ambiental, los materiales locales están desplazando opciones importadas.</p>

<h2>Lo que NO recomendamos seguir</h2>
<ul>
    <li><strong>Pasto artificial en exteriores soleados:</strong> calienta el suelo, no aporta beneficios ecológicos y se degrada rápido bajo radiación UV intensa.</li>
    <li><strong>Plantas exóticas demandantes en climas que no las soportan:</strong> compromisos hídricos y de mantenimiento desproporcionados.</li>
    <li><strong>Pavimentar áreas que podrían ser verdes:</strong> aumenta temperatura, escorrentía y desperdicia oportunidad.</li>
</ul>

<h2>Conclusión</h2>
<p>Las tendencias del 2026 no son caprichos estéticos: son respuestas a un contexto climático, social y económico distinto. Diseñar hoy implica pensar en el largo plazo, en la resiliencia y en la relación entre el espacio, las personas que lo habitan y el ecosistema que lo rodea.</p>

<p>Si estás planeando un proyecto nuevo o una renovación importante, agendemos una visita para construir una propuesta a la medida.</p>
HTML,
            ],
        ];

        foreach ($posts as $data) {
            Post::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'status' => 'published',
                ])
            );
        }
    }
}
