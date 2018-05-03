<?php
/**
 * Created by PhpStorm.
 * User: mbruchet
 * Date: 21/03/2018
 * Time: 09:20
 */

namespace PageBuilder\Event;

class PageBuilderEvents
{
    const PAGE_BUILDER_CREATE                  = 'action.page_builder.create';

    const PAGE_BUILDER_UPDATE                  = 'action.page_builder.update';

    const PAGE_BUILDER_DELETE                  = 'action.page_builder.delete';

    const PAGE_BUILDER_UPDATE_SEO              = 'action.page_builder.updateSeo';

    const PAGE_BUILDER_TOGGLE_VISIBILITY       = 'action.togglePageBuilderVisibility';

    const RELATED_PRODUCT_UPDATE_POSITION   = 'action.page_builder.relatedProduct.updatePosition'; // Update a related product position in a page builder
}
