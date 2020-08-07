{foreach from=$blocks item=$block}
    <section class="pcs__productcategoryslider">
        <h2 class="pcs__categoryName">{$block.title}</h2>
        <div class="pcs__container">
            <div class="pcs__products">
                {foreach from=$block.products item="product"}
                    {include file="catalog/_partials/miniatures/product.tpl" product=$product}
                {/foreach}
            </div>
            <a href="{$block.link}" class="pcs__more">{l s='Zobacz[0]wszystkie' sprintf=['[0]' => '</br>'] d='Modules.ProductCategorySlider.Shop'}</a>
        </div>
    </section>
{/foreach}


