<div id="confirmacaoExclusao" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-md text-center max-w-sm w-full">
        <h2 class="text-lg font-semibold mb-4">Tem certeza que deseja excluir?</h2>
        <div class="flex justify-around">
            <button id="btnConfirmarExclusao" class="bg-red-600 hover:bg-red-800 text-white px-4 py-2 rounded">
                Confirmar
            </button>
            <button id="btnCancelarExclusao" class="bg-gray-400 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Cancelar
            </button>
        </div>
    </div>
</div>


<script>
    function ModalDelete(component){
        const modal = document.getElementById('confirmacaoExclusao');

        modal.style.display = 'Flex';

        const btnConfirmarExclusao = document.getElementById('btnConfirmarExclusao');
        const btnCancelarExclusao = document.getElementById('btnCancelarExclusao');
        const formExcluir = component.parentElement;

        console.log(component);
        console.log(formExcluir);

        if (btnConfirmarExclusao) {
            btnConfirmarExclusao.addEventListener('click', function () {
                if (formExcluir) formExcluir.submit();
            });
        }

        if (btnCancelarExclusao) {
            btnCancelarExclusao.addEventListener('click', function () {
                if (modal) modal.style.display = 'none';
            });
        }
    }
</script>