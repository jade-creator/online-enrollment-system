<div class="-my-2 overflow-x-auto">
    <div class="h-auto py-2 align-middle inline-block min-w-full">
        <div class="overflow-hidden">
            
            <div class="w-full mt-3">
                <!-- Pagination and Datatable -->
                {{ $paginationLink }} 
                
                <div class="grid grid-cols-12 gap-2">
                    {{ $head }}
                </div>

                <div class="grid mt-2">
                    {{ $body }}
                </div>
            </div>
        </div>  
    </div>
</div>