function flashAlert(text, condition) {
    if (condition === undefined) {
        condition = 'success';
    }
    var alertBlock = '<div class="fade in flash-alert alert alert-'+ condition +'" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+ text +'</div>';

    $('.wrap > .container').prepend(alertBlock);
    var alertInstance = $('.wrap > .container').find('.flash-alert').fadeIn();
    setTimeout(function () { alertInstance.alert('close') }, 4000);
}
function makeDialogWithContainer (title, idDialog, wdtDialog, container) {
    var dialogHtml = '<div id="'+ idDialog +'" title="'+ title +'">' +
        '<div class="container-pjax" id="'+ container +'"></div>' +
        '</div>';
    $('.wrap > .container').append(dialogHtml);


    $('#' + idDialog).dialog({autoOpen: false, width: wdtDialog + 'px'});
}
function getAllTrWithDataKey(grid) {
    var idsList = [];
    grid.find('tr[data-key][class = warning]').each(function (index, element) {
        idsList.push($(element).attr('data-key'));
    });

    return idsList;
}


/* handlers instance*/
function handlerLoadFormInstance (event) {
    var dialog = 'instance-dialog';
    var container = 'instance-pjax';
    var title;

    event.data.action == 'coming-instances' ? title = 'Добавление экземпляров' : title = 'Редактирование экземпляра';

    var oldDialog = $('#' + dialog);

    if (!oldDialog.length) {
        makeDialogWithContainer(title, dialog, '600', container);
    } else if (event.data.action == 'coming-instances' && $('form').is('#coming-instances-form')) {
        oldDialog.dialog('open');
        return;
    } else {
        oldDialog.remove();
        makeDialogWithContainer(title, dialog, '600', container);
    }

    dialog = $('#' + dialog);
    container = $('#' + container);

    var url = $(this).attr('url-pjax');

    $.pjax.reload({container : container, url : url, type : 'GET', timeout : false, push : false, replace : false});

    container.on('pjax:success', function() {
        container.find('form').attr('action', url);
        dialog.dialog('open');
    });
}
function handlerCreateInstance(event) {
    event.preventDefault();
    var form = $(this);

    if (form.find('div.has-error').length) {
        return false;
    }

    var dialog = 'list-instances-dialog';
    var container = 'list-instances-pjax';

    var oldDialog = $('#' + dialog);

    if (oldDialog) oldDialog.remove();
    makeDialogWithContainer('Добавленные экземпляры', dialog, '600', container);

    dialog  = $('#' + dialog);
    container = $('#' + container);

    $.ajax({
        url: form.attr('action'),
        type : 'POST',
        data : form.serialize(),
        success : function (response) {
            if (response != false) {
                container.html(response);
                dialog.dialog('open');
                flashAlert('Экземпляры успешно добавлены!');
                var grid = $('#instance-grid');
                if (grid.length) {
                    $.pjax.reload({container : grid, type : 'POST', timeout : false, push : false, replace : false});
                }
            } else {
                flashAlert('Ошибка. Экземпляры не добавлены', 'warning');
            }
        },
        error : function () {
            flashAlert('Ошибка запроса', 'danger');
        }
    });
}
/* Обработчик изменится после изменения формы */
function handlerUpdateInstance(event) {
    event.preventDefault();
    var form = $(this);

    if (form.find('div.has-error').length) {
        return false;
    }

    $.ajax({
        url: form.attr('action'),
        type : 'POST',
        data : form.serialize(),
        success : function (response) {
            if (response != false) {
                flashAlert('Экземпляр успешно обновлен');
                if ($('#instance-grid').length) {
                    $.pjax.reload({container : $('#instance-grid'), type : 'POST', timeout : false, push : false, replace : false});
                } else if ($('#instance-view').length) {
                    $.pjax.reload({container : $('#instance-view'), type : 'POST', timeout : false, push : false, replace : false});
                }
            } else {
                flashAlert('Ошибка. Экземпляр не обновлен', 'warning');
            }
        },
        error : function () {
            flashAlert('Ошибка запроса', 'danger');
        }
    });
}



/* handlers publication */
function handlerLoadInfo(event) {
    event.preventDefault();
    event.stopPropagation();

    var dialog = 'info-dialog';
    var container = 'view-pjax';
    var title = event.data.title
    var oldDialog = $('#' + dialog);

    if (oldDialog.length) {
        oldDialog.remove();
    }
    makeDialogWithContainer(title, dialog, '600', container);

    dialog = $('#' + dialog);
    container = $('#' + container);

    var url = $(this).attr('url-pjax');

    $.pjax.reload({container : container, url : url, type : 'GET', timeout : false, push : false, replace : false});

    container.on('pjax:success', function() {
        dialog.dialog('open');
    });
}
function handlerLoadFormPublication(event) {
    event.stopPropagation();

    var dialog = 'publication-dialog';
    var container = 'publication-pjax';
    var title = event.data.action === 'create' ? 'Добавление издания' : 'Редактирование издания';

    var oldDialog = $('#' + dialog);

    if (!oldDialog.length) {
        makeDialogWithContainer(title, dialog, '650', container);
    } else if (event.data.action == 'create' && $('form').is('#create-publication-form')) {
        oldDialog.dialog('open');
        return;
    } else {
        oldDialog.remove();
        makeDialogWithContainer(title, dialog, '650', container);
    }

    dialog = $('#' + dialog);
    container = $('#' + container);

    var url = $(this).attr('url-pjax');

    $.pjax.reload({container : container, url : url, type : 'GET', timeout : false, push : false, replace : false});

    container.on('pjax:success', function() {
        container.find('form').attr('action', url);
        dialog.dialog('open');
    });
}

function handlerCreatePublication(event) {
    event.preventDefault();
    var form = $(this);

    if (form.find('div.has-error').length) {
        return false;
    }

    $.ajax({
        url: form.attr('action'),
        type : 'POST',
        data : form.serialize(),
        success : function (response) {
            if (response != false) {
                flashAlert('Издание успешно добавлено!');
                var grid = $('#publication-grid');
                if (grid.length) {
                    $.pjax.reload({
                        container : grid,
                        type : 'POST',
                        timeout : false,
                        push : false,
                        replace : false});
                }
            } else {
                flashAlert('Ошибка. Издание не добавлено', 'warning');
            }
        },
        error : function () {
            flashAlert('Ошибка запроса', 'danger');
        }
    });
}

function handlerUpdatePublication(event) {
    event.preventDefault();
    event.stopPropagation();

    var form = $(this);

    if (form.find('div.has-error').length) {
        return false;
    }

    $.ajax({
        url: form.attr('action'),
        type : 'POST',
        data : form.serialize(),
        success : function (response) {
            if (response != false) {
                flashAlert('Издание успешно обновлено!');
                var grid = $('#publication-grid');
                if (grid.length) {
                    $.pjax.reload({container : grid, type : 'GET', timeout : false, push : false, replace : false});
                }
            } else {
                flashAlert('Ошибка. Издание не обновлено', 'warning');
            }
        },
        error : function () {
            flashAlert('Ошибка запроса', 'danger');
        }
    });
}


/* handlers authors, publishers, publication-types, locations */
function handlerLoadFormRelatedEntities(event) {
    var dialog = event.data.dialog;
    var container = event.data.container;
    var title = event.data.title;

    var oldDialog = $('#' + dialog);

    if (oldDialog.find('form').length) {
        oldDialog.dialog('open');
        return;
    }
    makeDialogWithContainer(title, dialog, '500', container);

    dialog = $('#' + dialog);
    container = $('#' + container);

    var url = $(this).attr('url-pjax');

    $.pjax.reload({container : container, url : url, type : 'POST', timeout : false, push : false, replace : false});

    container.on('pjax:success', function() {
        dialog.dialog('open');
    });
}

function handlerCreateBookcase(event) {
    event.preventDefault();
    var form = $(this);

    if (form.find('div.has-error').length) {
        return false;
    }

    $.ajax({
        url: form.attr('action'),
        type : 'POST',
        data : form.serialize(),
        success : function (response) {
            if (response != false) {
                flashAlert('Шкаф успешно добавлен!');
                var grid = $('#bookcase-grid');
                if (grid.length) {
                    $.pjax.reload({container : grid, type : 'POST', timeout : false, push : false, replace : false});
                }
            } else {
                flashAlert('Ошибка. Шкаф не добавлен', 'warning');
            }
        },
        error : function () {
            flashAlert('Ошибка запроса', 'danger');
        }
    });
}
function handlerActionDiscipline(event){
    event.preventDefault();
    var form = $(this);
    var success = event.data.success;
    var error = event.data.error;

    if (form.find('div.has-error').length) {
        return false;
    }

    $.ajax({
        url: form.attr('action'),
        type : 'POST',
        data : form.serialize(),
        success : function (response) {
            if (response != false) {
                flashAlert(success);
                var grid = $('#discipline-grid');
                if (grid.length) {
                    $.pjax.reload({container : grid, type : 'POST', timeout : false, push : false, replace : false});
                }
            } else {
                flashAlert(error, 'warning');
            }
        },
        error : function () {
            flashAlert('Ошибка запроса', 'danger');
        }
    });
}

/* CYCLE */
function handlerLoadFormCycle(event) {
    var dialog = 'cycle-dialog';
    var container = 'cycle-pjax';
    var title = event.data.action === 'create' ? 'Добавление учебного цикла' : 'Редактирование учебного цикла';

    var oldDialog = $('#' + dialog);

    if (!oldDialog.length) {
        makeDialogWithContainer(title, dialog, '500', container);
    } else if (event.data.action == 'create' && $('form').is('#create-cycle-form')) {
        oldDialog.dialog('open');
        return;
    } else {
        oldDialog.remove();
        makeDialogWithContainer(title, dialog, '500', container);
    }

    dialog = $('#' + dialog);
    container = $('#' + container);

    var url = $(this).attr('url-pjax');

    $.pjax.reload({container : container, url : url, type : 'GET', timeout : false, push : false, replace : false});

    container.on('pjax:success', function() {
        container.find('form').attr('action', url);
        dialog.dialog('open');
    });
}
function handlerActionCycle(event) {
    event.preventDefault();
    var form = $(this);
    var success = event.data.success;
    var error = event.data.error;

    if (form.find('div.has-error').length) {
        return false;
    }

    $.ajax({
        url: form.attr('action'),
        type : 'POST',
        data : form.serialize(),
        success : function (response) {
            if (response != false) {
                flashAlert(success);
                var grid = $('#cycle-grid');
                if (grid.length) {
                    $.pjax.reload({container : grid, type : 'POST', timeout : false, push : false, replace : false});
                }
            } else {
                flashAlert(error, 'warning');
            }
        },
        error : function () {
            flashAlert('Ошибка запроса', 'danger');
        }
    });
}

/* DISCIPLINE */
function handlerLoadFormDiscipline(event) {
    var dialog = event.data.dialog;
    var container = event.data.container;
    var title = event.data.title;

    var oldDialog = $('#' + dialog);

    if (oldDialog.length) {
        oldDialog.remove();
    }
    makeDialogWithContainer(title, dialog, '500', container);

    dialog = $('#' + dialog);
    container = $('#' + container);

    var url = $(this).attr('url-pjax');

    $.pjax.reload({container : container, url : url, type : 'GET', timeout : false, push : false, replace : false});

    container.on('pjax:success', function() {
        container.find('form').attr('action', url);
        dialog.dialog('open');
    });
}


/* PUBLISHER */
function handlerLoadFormPublisher(event) {
    var dialog = event.data.dialog;
    var container = event.data.container;
    var title = event.data.title;

    var oldDialog = $('#' + dialog);

    if (oldDialog.length) {
        oldDialog.remove();
    }
    makeDialogWithContainer(title, dialog, '500', container);

    dialog = $('#' + dialog);
    container = $('#' + container);

    var url = $(this).attr('url-pjax');

    $.pjax.reload({container : container, url : url, type : 'GET', timeout : false, push : false, replace : false});

    container.on('pjax:success', function() {
        container.find('form').attr('action', url);
        dialog.dialog('open');
    });
}
function handlerActionPublisher(event){
    event.preventDefault();
    var form = $(this);
    var success = event.data.success;
    var error = event.data.error;

    if (form.find('div.has-error').length) {
        return false;
    }

    $.ajax({
        url: form.attr('action'),
        type : 'POST',
        data : form.serialize(),
        success : function (response) {
            if (response != false) {
                flashAlert(success);
                var grid = $('#publisher-grid');
                if (grid.length) {
                    $.pjax.reload({container : grid, type : 'POST', timeout : false, push : false, replace : false});
                }
            } else {
                flashAlert(error, 'warning');
            }
        },
        error : function () {
            flashAlert('Ошибка запроса', 'danger');
        }
    });
}

/* AUTHOR */
function handlerLoadFormAuthor(event) {
    event.preventDefault();
    event.stopPropagation();

    var dialog = event.data.dialog;
    var container = event.data.container;
    var title = event.data.title;

    var oldDialog = $('#' + dialog);

    if (oldDialog.length) {
        oldDialog.remove();
    }
    makeDialogWithContainer(title, dialog, '500', container);

    dialog = $('#' + dialog);
    container = $('#' + container);

    var url = $(this).attr('url-pjax');

    $.pjax.reload({container : container, url : url, type : 'GET', timeout : false, push : false, replace : false});

    container.on('pjax:success', function() {
        container.find('form').attr('action', url);
        dialog.dialog('open');
    });
}
function handlerActionAuthor(event){
    event.preventDefault();
    var form = $(this);
    var success = event.data.success;
    var error = event.data.error;

    if (form.find('div.has-error').length) {
        return false;
    }

    $.ajax({
        url: form.attr('action'),
        type : 'POST',
        data : form.serialize(),
        success : function (response) {
            if (response != false) {
                flashAlert(success);
                var grid = $('#author-grid');
                if (grid.length) {
                    $.pjax.reload({container : grid, type : 'POST', timeout : false, push : false, replace : false});
                }
            } else {
                flashAlert(error, 'warning');
            }
        },
        error : function () {
            flashAlert('Ошибка запроса', 'danger');
        }
    });
}


/* PUBLICATION TYPE */
function handlerLoadFormPublicationType(event) {
    var dialog = event.data.dialog;
    var container = event.data.container;
    var title = event.data.title;

    var oldDialog = $('#' + dialog);

    if (oldDialog.length) {
        oldDialog.remove();
    }
    makeDialogWithContainer(title, dialog, '500', container);

    dialog = $('#' + dialog);
    container = $('#' + container);

    var url = $(this).attr('url-pjax');

    $.pjax.reload({container : container, url : url, type : 'GET', timeout : false, push : false, replace : false});

    container.on('pjax:success', function() {
        container.find('form').attr('action', url);
        dialog.dialog('open');
    });
}
function handlerActionPublicationType(event){
    event.preventDefault();
    var form = $(this);
    var success = event.data.success;
    var error = event.data.error;

    if (form.find('div.has-error').length) {
        return false;
    }

    $.ajax({
        url: form.attr('action'),
        type : 'POST',
        data : form.serialize(),
        success : function (response) {
            if (response != false) {
                flashAlert(success);
                var grid = $('#publication-type-grid');
                if (grid.length) {
                    $.pjax.reload({container : grid, type : 'POST', timeout : false, push : false, replace : false});
                }
            } else {
                flashAlert(error, 'warning');
            }
        },
        error : function () {
            flashAlert('Ошибка запроса', 'danger');
        }
    });
}


function handlerFilter (event) {
    event.preventDefault();
    var container = $(event.data.container);

    $.pjax.reload({container : container, url : $(this).attr('action'), type : 'GET', data: $(this).serialize(), timeout : false, push : false, replace : false});
    container.on('pjax:error', function() {
        flashAlert('Ошибка запроса', 'danger');
    });
}

/* handlers button grid-view */
function handlerBatchAction(event) {
    event.preventDefault();

    var grid = $(this).closest('.grid-view');
    var idsList = getAllTrWithDataKey(grid);

    if (idsList.length === 0) {
        flashAlert('Выберите хотя бы один элемент', 'info');
        return;
    }

    if (!confirm(event.data.textConfirm)) {
        return false;
    }

    var url = $(this).attr('url-ajax');
    var gridPjax = grid.parent();
    var textSuccess = event.data.textSuccess;
    var textError = event.data.textError;

    $.ajax({url: url, type: 'POST', data: {ids: idsList},
        success: function (response) {
            if (response != false) {
                flashAlert(textSuccess);
                $.pjax.reload(gridPjax, {timeout: false, push : false, replace : false, type: 'POST'});
                return;
            } else {
                flashAlert(textError, 'warning');
                return;
            }
        },
        error: function () {
            flashAlert('Ошибка запроса', 'danger')
        }});
}
function handlerDeleteOne(event) {
    event.preventDefault();

    if (!confirm(event.data.textConfirm)) {
        return;
    }

    var ids = [$(this).attr('instance-id')];
    var textError = event.data.textError;
    var textSuccess = event.data.textSuccess;

    $.ajax({url: $(this).attr('url-ajax'), type: 'POST', data: {ids: ids},
        success: function (response) {
            if (response != false) {
                flashAlert(textSuccess);
                window.history.back();
            } else {
                flashAlert(textError, 'warning');
                return;
            }
        },
        error: function () {
            flashAlert('Ошибка запроса', 'danger')
        }});
}
function handlerInArchiveOne(event) {
    event.preventDefault();

    if (!confirm(event.data.textConfirm)) {
        return;
    }

    var ids = [$(this).attr('instance-id')];
    var textError = event.data.textError;
    var textSuccess = event.data.textSuccess;

    $.ajax({url: $(this).attr('url-ajax'), type: 'POST', data: {ids: ids},
        success: function (response) {
            if (response != false) {
                if ($('#instance-view').length) {
                    $.pjax.reload({container : $('#instance-view'), type : 'POST', timeout : false, push : false, replace : false});
                }
                flashAlert(textSuccess);
            } else {
                flashAlert(textError, 'warning');
                return;
            }
        },
        error: function () {
            flashAlert('Ошибка запроса', 'danger')
        }});
}
function handlerOutArchiveOne(event) {
    event.preventDefault();

    if (!confirm(event.data.textConfirm)) {
        return;
    }

    var ids = [$(this).attr('instance-id')];
    var textError = event.data.textError;
    var textSuccess = event.data.textSuccess;

    $.ajax({url: $(this).attr('url-ajax'), type: 'POST', data: {ids: ids},
        success: function (response) {
            if (response != false) {
                flashAlert(textSuccess);

                var container = $('#instance-view');
                if (container.length) {
                    $.pjax.reload({container : container, type : 'POST', timeout : false, push : false, replace : false});
                }

                container.one('pjax:success', function () {
                    $('.btn-dialog-update-instance').trigger('click');
                });
            } else {
                flashAlert(textError, 'warning');
                return;
            }
        },
        error: function () {
            flashAlert('Ошибка запроса', 'danger')
        }});
}

function handlerLostOne(event) {
    event.preventDefault();

    if (!confirm(event.data.textConfirm)) {
        return;
    }

    var ids = [$(this).attr('instance-id')];
    var textError = event.data.textError;
    var textSuccess = event.data.textSuccess;

    $.ajax({url: $(this).attr('url-ajax'), type: 'POST', data: {ids: ids},
        success: function (response) {
            if (response != false) {
                if ($('#instance-view').length) {
                    $.pjax.reload({container : $('#instance-view'), type : 'POST', timeout : false, push : false, replace : false});
                }
                flashAlert(textSuccess);
            } else {
                flashAlert(textError, 'warning');
                return;
            }
        },
        error: function () {
            flashAlert('Ошибка запроса', 'danger')
        }});
}
function handlerFoundOne(event) {
    event.preventDefault();

    if (!confirm(event.data.textConfirm)) {
        return;
    }

    var ids = [$(this).attr('instance-id')];
    var textError = event.data.textError;
    var textSuccess = event.data.textSuccess;

    $.ajax({url: $(this).attr('url-ajax'), type: 'POST', data: {ids: ids},
        success: function (response) {
            if (response != false) {
                flashAlert(textSuccess);

                var container = $('#instance-view');
                if (container.length) {
                    $.pjax.reload({container : container, type : 'POST', timeout : false, push : false, replace : false});
                }

                container.one('pjax:success', function () {
                    $('.btn-dialog-update-instance').trigger('click');
                });
            } else {
                flashAlert(textError, 'warning');
                return;
            }
        },
        error: function () {
            flashAlert('Ошибка запроса', 'danger')
        }});
}
function handlerDeleteActionColumn(event) {
    event.stopPropagation();
    event.preventDefault();

    if (!confirm(event.data.textConfirm)) {
        return;
    }

    var ids = $(this).attr('element-id');
    var textError = event.data.textError;
    var textSuccess = event.data.textSuccess;
    var grid = $(this).closest('.grid-view').parent();

    $.ajax({url: $(this).attr('url-ajax'), type: 'POST', data: {ids: ids},
        success: function (response) {
            if (response != false) {
                flashAlert(textSuccess);
                $.pjax.reload({container : grid, type : 'POST', timeout : false, push : false, replace : false});
                return;
            } else {
                flashAlert(textError, 'warning');
                return;
            }
        },
        error: function () {
            flashAlert('Ошибка запроса', 'danger')
        }});
}

$(document).ready(function() {

    /* Dialog LOAD FORM INSTANCES */
    $(document).on('click', '.btn-dialog-coming-instances', {action: 'coming-instances'}, handlerLoadFormInstance);
    $(document).on('click', '.btn-dialog-update-instance', {action: 'update-instance'}, handlerLoadFormInstance);

    /* Form SEND FORM INSTANCE */
    $(document).on('submit', '#coming-instances-form', handlerCreateInstance);
    $(document).on('submit', '#update-instance-form', handlerUpdateInstance);

    /* Dialog LOAD FORM PUBLICATION */
    $(document).on('click', '.btn-dialog-info', {title: 'Детальная информация'}, handlerLoadInfo);
    $(document).on('click', '.btn-dialog-create-publication', {action: 'create'}, handlerLoadFormPublication);
    $(document).on('click', '.btn-dialog-update-publication', {action: 'update'}, handlerLoadFormPublication);

    /* Dialog CREATE PUBLICATION */
    $(document).on('submit', '#create-publication-form', handlerCreatePublication);
    $(document).on('submit', '#update-publication-form', handlerUpdatePublication);

    /* Dialog LOAD FORM AUTHORS */
    $(document).on('submit', '#create-authors-form', {success: 'Авторы успешно добавлены', error: 'Ошибка. Авторы не добавлены'}, handlerActionAuthor);
    $(document).on('submit', '#update-author-form', {success: 'Авторы успешно изменены', error: 'Ошибка. Автор не изменён'}, handlerActionAuthor);
    $(document).on('click', '.btn-dialog-create-authors', {dialog: 'authors-dialog', container: 'authors-pjax', title: 'Добавление авторов'}, handlerLoadFormRelatedEntities);
    $(document).on('click', '.btn-dialog-update-author', {dialog: 'author-dialog', container: 'author-pjax', title: 'Редактирование автора'}, handlerLoadFormAuthor);

    /* Dialog LOAD FORM PUBLICATION TYPES */
    $(document).on('click', '.btn-dialog-create-publication-types', {dialog: 'publication-types-dialog', container: 'publication-types-pjax', title: 'Добавление видов изданий'}, handlerLoadFormRelatedEntities);
    $(document).on('click', '.btn-dialog-update-publication-type', {dialog: 'publication-type-dialog', container: 'publication-type-pjax', title: 'Редактирование вида издания'}, handlerLoadFormPublicationType);
    $(document).on('submit', '#create-publication-types-form', {success: 'Виды изданий успешно добавлены', error: 'Ошибка. Виды изданий не добавлены'}, handlerActionPublicationType);
    $(document).on('submit', '#update-publication-type-form', {success: 'Вид издания успешно изменён', error: 'Ошибка. Вид издания не изменен'}, handlerActionPublicationType);

    /* Dialog LOAD FORM PUBLISHERS */
    $(document).on('click', '.btn-dialog-create-publishers', {dialog: 'publishers-dialog', container: 'publishers-pjax', title: 'Добавление издателей'}, handlerLoadFormRelatedEntities);
    $(document).on('click', '.btn-dialog-update-publisher', {dialog: 'publisher-dialog', container: 'publisher-pjax', title: 'Редактирование издателя'}, handlerLoadFormPublisher);
    $(document).on('submit', '#create-publishers-form', {success: 'Издатели успешно добавлены', error: 'Ошибка. Издатели не добавлены'}, handlerActionPublisher);
    $(document).on('submit', '#update-publisher-form', {success: 'Издатель успешно изменён', error: 'Ошибка. Издатель не изменен'}, handlerActionPublisher);

    /* Dialog LOAD FORM BOOKCASE */
    $(document).on('click', '.btn-dialog-create-bookcase', {dialog: 'bookcase-dialog', container: 'bookcase-pjax', title: 'Добавление шкафа'}, handlerLoadFormRelatedEntities);
    $(document).on('submit', '#bookcase-form', handlerCreateBookcase);

    /* Dialog LOAD FORM CYCLE */
    $(document).on('click', '.btn-dialog-create-cycle', {action: 'create'}, handlerLoadFormCycle);
    $(document).on('click', '.btn-dialog-update-cycle', {action: 'update'}, handlerLoadFormCycle);
    $(document).on('submit', '#create-cycle-form', {success: 'Учебный цикл успешно добавлен', error: 'Ошибка. Учебный цикл не добавлен'}, handlerActionCycle);
    $(document).on('submit', '#update-cycle-form', {success: 'Учебный цикл успешно изменён', error: 'Ошибка. Учебный цикл не изменён'}, handlerActionCycle);

    /* Dialog LOAD FORM DISCIPLINE */
    $(document).on('submit', '#create-disciplines-form', {success: 'Дисциплины успешно добавлены', error: 'Ошибка. Дисциплины не добавлены'}, handlerActionDiscipline);
    $(document).on('submit', '#update-discipline-form', {success: 'Дисциплина успешно изменена', error: 'Ошибка. Дисциплина не изменена'}, handlerActionDiscipline);
    $(document).on('click', '.btn-dialog-create-disciplines', {dialog: 'disciplines-dialog', container: 'disciplines-pjax', title: 'Добавление дисциплин'}, handlerLoadFormRelatedEntities);
    $(document).on('click', '.btn-dialog-update-discipline', {dialog: 'discipline-dialog', container: 'discipline-pjax', title: 'Редактирование дисциплины'}, handlerLoadFormDiscipline);





    $(document).on('reset', 'form', function (event) {
        event.preventDefault();

        var form = $(this);
        form.find('input').each( function() {
            $(this).val(null);
        });

        form.find('.multiple').children().html('');
        //form.find('.select2-hidden-accessible').select2('data', {id: null, text: null});
        form.find('.select2-hidden-accessible').val(null).trigger('change');
        form.find('.depdrop-child').val(0).trigger('change');
    });
    $(document).on('click', '.btn-filter', function () {
        var currentUrl = window.location.href;
        history.replaceState({foo: 'bar'}, '', currentUrl.replace(/\?[\s\S]+/g, ''));
    });
    $(document).on('click', '.grid-view table tr[data-key]', function() {
        if (!$(this).hasClass('warning')) {
            $($(this).addClass('warning'));
            return;
        }
        $(this).removeAttr('class');
    });
    $(document).on('click', '.btn-dialog-filter', function() {
        $('#dialog-filter').dialog('open');
    });

    /* Buttons GridView */ /* PUBLICATON */
    $(document).on('click', '.btn-in-archive', {
        textConfirm: 'Перенести все экземпляры выбранных изданий в архив?',
        textSuccess: 'Экземпляры перенесены в архив!',
        textError: 'Ошибка. Экземпляры не перенесены в архив'}, handlerBatchAction);
    $(document).on('click', '.btn-delete', {
        textConfirm: 'Удалить выбранные издания?',
        textSuccess: 'Издания удалены!',
        textError: 'Ошибка. Издания не удалены'}, handlerBatchAction);



    /* Buttons VIEW */
    $(document).on('click', '.btn-delete-view', {textConfirm: 'Вы уверены что хотите удалить экземпляр?', textError: 'Ошибка. Экземпляр не удалён', textSuccess: 'Экземпляр удалён!'}, handlerDeleteOne);
    $(document).on('click', '.btn-in-archive-view', {textConfirm: 'Переместить экземпляр в архив?', textError: 'Ошибка. Экземпляр не перемещён в архив', textSuccess: 'Экземпляр перемещён в архив!'}, handlerInArchiveOne);
    $(document).on('click', '.btn-out-archive-view', {textConfirm: 'Переместить  экземпляр из архива?', textError: 'Ошибка. Экземпляр не перемещён из архива', textSuccess: 'Экземпляр перемещён из архива!'}, handlerOutArchiveOne);
    $(document).on('click', '.btn-found-view', {textConfirm: 'Пометить экземпляр найденным?', textError: 'Ошибка. Экземпляр не помечен', textSuccess: 'Экземпляр помечен найденным!'}, handlerFoundOne);
    $(document).on('click', '.btn-lost-view', {textConfirm: 'Пометить экземпляр потерянным?', textError: 'Ошибка. Экземпляр не помечен', textSuccess: 'Экземпляр помечен потерянным!'}, handlerLostOne);

    $(document).on('click', '.btn-delete-action', {textConfirm: 'Вы уверены что хотите удалить эту запись?', textError: 'Ошибка. Запись не удалена', textSuccess: 'Запись удалена!'}, handlerDeleteActionColumn);



    /* PUBLICATION INSTANCE */
    $(document).on('click', '.btn-in-archive-instances', {
        textConfirm: 'Перенести все выбранные экземпляры в архив?',
        textSuccess: 'Экземпляры перенесены в архив!',
        textError: 'Ошибка. Экземпляры не перенесены в архив'}, handlerBatchAction);
    $(document).on('click', '.btn-out-archive-instances', {
        textConfirm: 'Перенести все выбранные экземпляры из архива?',
        textSuccess: 'Экземпляры перенесены из архива!',
        textError: 'Ошибка. Экземпляры не перенесены из архива'}, handlerBatchAction);
    $(document).on('click', '.btn-lost-instances', {
        textConfirm: 'Пометить выбранные экземпляры как потерянные?',
        textSuccess: 'Экземпляры помечены как потерянные!',
        textError: 'Ошибка. Экземпляры не помечены как потерянные'}, handlerBatchAction);
    $(document).on('click', '.btn-found-instances', {
        textConfirm: 'Пометить выбранные экземпляры как найденные?',
        textSuccess: 'Экземпляры помечены как найденные!',
        textError: 'Ошибка. Экземпляры не помечены как найденные'}, handlerBatchAction);
    $(document).on('click', '.btn-delete-instances', {
        textConfirm: 'Удалить выбранные экземпляры?',
        textSuccess: 'Экземпляры удалены!',
        textError: 'Ошибка. Экземпляры не удалены'}, handlerBatchAction);


    // Select-all Unselect-all
    $(document).on('click', '.btn-select-all', function (event) {
        event.preventDefault();
        var grid = $(this).closest('.grid-view');
        grid.find('tr[data-key]').addClass('warning');
    });
    $(document).on('click', '.btn-unselect-all', function (event) {
        event.preventDefault();
        var grid = $(this).closest('.grid-view');
        grid.find('tr[data-key]').removeAttr('class');
    });

    $(document).on('click', '.btn-select-all-checkbox-form', function () {
        var form = $(this).closest('form');
        form.find('input:checkbox').prop('checked', true);
    });

    $(document).on('click', '.btn-unselect-all-checkbox-form', function () {
        var form = $(this).closest('form');
        form.find('input:checkbox').removeAttr('checked');
    });

    // Disabled fields BOOKCASE BOOKSHELF
    $(document).on('click', '.field-in_archive input[type="checkbox"]', function () {
        var bookcase = $('#bookcase');
        var bookshelf = $('#bookshelf');

        if ($(this).prop('checked')) {
            bookcase.prop('disabled', true);
            bookshelf.prop('disabled', true);
        } else {
            bookcase.prop('disabled', false);
            bookcase.val(null).trigger('change');
        }
    });
    $(document).on('submit', '#filter-publication-form', {container: '#publication-grid'}, handlerFilter);
    $(document).on('submit', '#filter-instance-form', {container: '#instance-grid'}, handlerFilter);
});