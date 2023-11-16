const page = document.querySelector(`.content`);
const sidebar = document.querySelector(`.sidebar`);
const headers = document.querySelectorAll(`.content h2`);

if (page && sidebar && headers.length > 0) {
    /* Построение сайдбара */
    headers.forEach((header, i) => {
        const template = document.querySelector(`.template-sidebar-item`).content.querySelector(`.sidebar__item`);
        const newItem = template.cloneNode(true);
        const newItemLink = newItem.querySelector(`.sidebar__link`);

        header.id = `sidebar-header-${i+1}`;
        newItemLink.textContent = header.textContent;
        newItemLink.href = `#${header.id}`;

        sidebar.appendChild(newItem);
    });

    const sidebarItems = sidebar.querySelectorAll(`.sidebar__item`);
    let sidebarActiveItem;

    /* Установка начального активного пункта в сайдбаре */
    sidebarItems[0].classList.add(`sidebar__item--active`);
    sidebarActiveItem = sidebarItems[0];

    /* Изменение активного пункта в сайдбаре при скролле страницы */
    const textPageScrollHandler = () => {
        headers.forEach((header, i) => {
            if (header.getBoundingClientRect().top < 125) {
                sidebarActiveItem.classList.remove(`sidebar__item--active`);
                sidebarActiveItem = sidebarItems[i];
                sidebarItems[i].classList.add(`sidebar__item--active`);
            }
        });
    };

    document.addEventListener(`scroll`, textPageScrollHandler);

    /* Скролл к пункту в контенте по клику на соотв. ссылку сайдбара */
    sidebarItems.forEach((sidebarItem, i) => {
        sidebarItem.addEventListener(`click`, (evt) => {
            evt.preventDefault();
            const elemCoordY = headers[i].getBoundingClientRect().top;

            document.removeEventListener(`scroll`, textPageScrollHandler);
            sidebarActiveItem.classList.remove(`sidebar__item--active`);
            sidebarItem.classList.add(`sidebar__item--active`);
            sidebarActiveItem = sidebarItem;

            window.scrollBy({
                top: elemCoordY - 70,
                behavior: "smooth"
            });

            const textPageScrollHandlerWrapper = () => {
                document.addEventListener(`scroll`, textPageScrollHandler);
            }

            setTimeout(textPageScrollHandlerWrapper, 700);
        });
    });
}