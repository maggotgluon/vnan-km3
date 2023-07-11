<div>
    
    <!-- Canvas to place the PDF -->
    <div class="my-4 flex gap-2 items-center">
        <x-button.circle icon="chevron-left"  id="prev_page"/>
        <x-input type="number" value="1" id="current_page" readonly hidden class="hidden"/>
        <x-badge>
            หน้า
            <span id="page_num"></span>
            /
            <span id="page_count"></span>
        </x-badge>
        <x-button.circle icon="chevron-right" id="next_page"/>

        <span class="ml-auto"></span>

        <x-button.circle icon="zoom-out" id="zoom_out"/>
        <x-button.circle icon="zoom-in" id="zoom_in"/>
    </div>
    <!-- Canvas to place the PDF -->
    <canvas id="canvas" class="canvas__container max-w-full h-auto m-auto" ></canvas>



    <!-- Load PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"
        integrity="sha512-Z8CqofpIcnJN80feS2uccz+pXWgZzeKxDsDNMD/dJ6997/LSRY+W4NmEt9acwR+Gt9OHN0kkI1CTianCwoqcjQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        console.log(@js($file));
        const pdf = @js($file);

        const pageNum = document.querySelector('#page_num');
        const pageCount = document.querySelector('#page_count');
        const currentPage = document.querySelector('#current_page');
        const previousPage = document.querySelector('#prev_page');
        const nextPage = document.querySelector('#next_page');
        const zoomIn = document.querySelector('#zoom_in');
        const zoomOut = document.querySelector('#zoom_out');

        const initialState = {
            pdfDoc: null,
            currentPage: 1,
            pageCount: 0,
            zoom: 1,
        };

        pdfjsLib
            .getDocument(pdf)
            .promise.then((data) => {
                initialState.pdfDoc = data;
                console.log('pdfDocument', initialState.pdfDoc);

                pageCount.textContent = initialState.pdfDoc.numPages;

                renderPage();
            })
            .catch((err) => {
                alert(err.message);
            });

        // Render the page.
        const renderPage = () => {
            // Load the first page.
            console.log(initialState.pdfDoc, 'pdfDoc');
            initialState.pdfDoc
                .getPage(initialState.currentPage)
                .then((page) => {
                    console.log('page', page);

                    const canvas = document.querySelector('#canvas');
                    const ctx = canvas.getContext('2d');
                    const viewport = page.getViewport({
                        scale: initialState.zoom,
                    });

                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Render the PDF page into the canvas context.
                    const renderCtx = {
                        canvasContext: ctx,
                        viewport: viewport,
                    };

                    page.render(renderCtx);

                    pageNum.textContent = initialState.currentPage;
                });
        };
        const showPrevPage = () => {
            if (initialState.pdfDoc === null || initialState.currentPage <= 1)
                return;
            initialState.currentPage--;
            // Render the current page.
            currentPage.value = initialState.currentPage;
            renderPage();
        };

        const showNextPage = () => {
            if (
                initialState.pdfDoc === null ||
                initialState.currentPage >= initialState.pdfDoc._pdfInfo.numPages
            )
                return;

            initialState.currentPage++;
            currentPage.value = initialState.currentPage;
            renderPage();
        };

        // Button events.
        previousPage.addEventListener('click', showPrevPage);
        nextPage.addEventListener('click', showNextPage);

        // Keypress event.
        currentPage.addEventListener('keypress', (event) => {
            if (initialState.pdfDoc === null) return;
            // Get the key code.
            const keycode = event.keyCode ? event.keyCode : event.which;

            if (keycode === 13) {
                // Get the new page number and render it.
                let desiredPage = currentPage.valueAsNumber;
                initialState.currentPage = Math.min(
                    Math.max(desiredPage, 1),
                    initialState.pdfDoc._pdfInfo.numPages,
                );

                currentPage.value = initialState.currentPage;
                renderPage();
            }
        });

        // Zoom events.
        zoomIn.addEventListener('click', () => {
            if (initialState.pdfDoc === null) return;
            initialState.zoom *= 4 / 3;
            renderPage();
        });

        zoomOut.addEventListener('click', () => {
            if (initialState.pdfDoc === null) return;
            initialState.zoom *= 2 / 3;
            renderPage();
        });
    </script>
</div>
