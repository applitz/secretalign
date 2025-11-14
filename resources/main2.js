import * as FilePond from '../node_modules/filepond/dist/filepond.esm.js';
import FilePondPluginFilePoster from '../node_modules/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.esm.js';
import FilePondPluginImageEditor from '../node_modules/@pqina/filepond-plugin-image-editor/dist/FilePondPluginImageEditor.js';




// Register FilePond plugins
FilePond.registerPlugin(
    FilePondPluginImageEditor,
    FilePondPluginFilePoster
);

import {
    openEditor,
    createDefaultImageReader,
    createDefaultImageWriter,
    processImage,
    getEditorDefaults,
} from '../node_modules/@pqina/pintura/pintura.js';
const URL = $("#piquaScript").attr('data-urls');
const ASSET = $("#piquaScript").attr('data-assets');
const PATIENTID = $("#piquaScript").attr('data-patient-id');
const CASEID = $("#piquaScript").attr('data-case-id');
/* Uncomment to load video editor extension
import {
    setPlugins,
    createDefaultMediaWriter,
    imageStateToCanvas,
} from './node_modules/@pqina/pintura/pintura.js';

import {
    plugin_trim_locale_en_gb,
    plugin_trim,
    createDefaultVideoWriter,
    createMediaStreamEncoder,
} from './node_modules/@pqina/pintura-video/dist/pinturavideo.js';

// Load the Trim plugin view
setPlugins(plugin_trim);
*/

var files = [];
var inputElements = $(".filepond");
inputElements.each((index) => {

    let load_files = [

    ];
    var inputElement = inputElements.eq(index)
    var id = inputElement.attr('data-field')
    var file = inputElement.attr('file')

    var acceptedFiles = ['image/*'];
    if (id == 1 || id == 2) {
        acceptedFiles = [];
    }
    if (id >= 13) {
        acceptedFiles = ['application/pdf', 'image/*'];
    }
    if (file != '') {
        load_files.push({
            options: {
                type: 'local',
            },
            source: file
        });
        files.push(id + "__" + file);
    }
    FilePond.registerPlugin(


FilePondPluginFileValidateType,
FilePondPluginImageExifOrientation,
FilePondPluginImagePreview,
FilePondPluginImageCrop,
FilePondPluginImageResize,
FilePondPluginImageTransform,
FilePondPluginImageEdit,
    );
    // create a FilePond instance at the input element location
    FilePond.create(

        document.querySelector('#key' + id), {
            // stylePanelLayout: 'compact circle',
            // styleLoadIndicatorPosition: 'center top',
            // styleButtonRemoveItemPosition: 'center top',


            allowReorder: true,
     filePosterMaxHeight: 256,

    // Image Editor plugin properties
    imageEditor: {
        // used to create the editor, receives editor configuration, should return an editor instance
        createEditor: openEditor,

        // Required, used for reading the image data
        imageReader: [createDefaultImageReader],

        // optionally. can leave out when not generating a preview thumbnail and/or output image
        imageWriter: [
            // The image writer to use
            createDefaultImageWriter,
            // optional image writer instructions, this instructs the image writer to resize the image to match a width of 384 pixels
            // {
            //     targetSize: {
            //         width: 128,
            //     },
            // },

            /* Uncomment when editing videos, remove above code
            () =>
                createDefaultMediaWriter(
                    // Generic Media Writer options, passed to image and video writer
                    {
                        targetSize: {
                            width: 400,
                        },
                    },
                    [
                        // For handling images
                        createDefaultImageWriter(),

                        // For handling videos
                        createDefaultVideoWriter({
                            // Video writer instructions here
                            // ...

                            // Encoder to use
                            encoder: createMediaStreamEncoder({
                                imageStateToCanvas,
                            }),
                        }),
                    ]
                ),
                */
        ],

        // used to generate poster images, runs an editor in the background
        imageProcessor: processImage,

        // Pintura Image Editor properties
        editorOptions: {
            // pass the editor default configuration options
            ...getEditorDefaults({
                /* Uncomment when editing videos
                locale: { ...plugin_trim_locale_en_gb },
                */
            }),

            // we want a square crop
            imageCropAspectRatio: 0,
        },

        /* uncomment if you've used FilePond with version 6 of Pintura and are loading old file metadata
        // map legacy data objects to new imageState objects
        legacyDataToImageState: legacyDataToImageState,
        */
    },

    /* Ucomment when editing videos
    filePosterFilterItem: (item) => {
        // We currently cannot create video posters
        return /image/.test(item.fileType);
    },
    */

    /* Ucomment when editing videos
    // When editing video's it's advised to use asynchronous uploading, this will trigger video processing on upload instead of on file drop
    instantUpload: false,
    server: {
        // https://pqina.nl/filepond/docs/api/server/#end-points
    },
    */

    /* Uncomment when editing videos
    imageEditorSupportImage: (file) =>
        /image/.test(file.type) || /video/.test(file.type),
    */

    /* uncomment to preview the resulting file in the document after editing
    onpreparefile: (fileItem, file) => {
        const media = document.createElement(
            /video/.test(file.type) ? 'video' : 'img'
        );
        media.controls = true;
        media.src = URL.createObjectURL(file);
        document.body.appendChild(media);
    },
     */
            name: 'attachment',
            oninit: () => {
                // Add a `data-file` attribute to the element
                document.querySelector('#key' + id).setAttribute('file', file);
            },
            allowMultiple: false,
            // allowImagePreview: true,
            // imagePreviewFilterItem: false,
            // imagePreviewMarkupFilter: false,

            //dataMaxFileSize:"20MB",
            acceptedFileTypes: acceptedFiles,
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    // Do custom type detection here and return with promise

                    resolve(type);
                }),
            // server
            server: {
                process: {
                    url: URL+'/demo/patient/file/upload/'+PATIENTID+'/'+CASEID+'?id='+id,
                    method: 'POST',
                    headers: {
                        'x-customheader': 'Processing File'
                    },
                    onload: (response) => {
                        response = response;
                        $('#key' + id).attr('file', response);
                        console.log(id)
                        if(id == 1) {
                          //  window.previewUpperStlFile(ASSET+'/PatientFiles/Patient'+PATIENTID+'/'+response.replace(/"/g, ''))
                        }
                        if(id == 2) {
                          //  window.previewLowerStlFile(ASSET+'/PatientFiles/Patient'+PATIENTID+'/'+response.replace(/"/g, ''))
                        }
                        files.push(id + '__' + response);
                        return response;

                    },
                    onerror: (response) => {
                        console.log(response)
                        return response
                    },
                    ondata: (formData) => {
                        //console.log(formData)
                        window.h = formData;

                        return formData;
                    }
                },
                revert: (uniqueFileId, load, error) => {
                    const formData = new FormData();
                    formData.append("key", uniqueFileId);
                    files = files.filter(function(ele) {
                        return ele != id + '__' + uniqueFileId;
                    });

                    fetch(`${URL}/demo/patient/file/revert/${PATIENTID}/${CASEID}?key=${uniqueFileId}&id=` +
                            id, {
                                method: "DELETE",
                                body: formData,
                            }).then(res => res.json())
                        .then(json => {
                            // Should call the load method when done, no parameters required
                            $('#key' + id).attr('file', '');
                            if(id == 1) {
                                window.destroyPreview1();
                                $("#stl-upper-arch-preview").html("");
                            }
                            if(id == 2) {
                                window.destroyPreview2();
                                $("#stl-lower-arch-preview").html("");
                            }
                            load();

                        })
                        .catch(err => {
                            // Can call the error method if something is wrong, should exit after
                            error(err.message);
                        })
                },

                load: (uniqueFileId, load, error, progress, abort, headers) => {
                    // implement logic to load file from server here
                    // https://pqina.nl/filepond/docs/patterns/api/server/#load-1

                    let controller = new AbortController();
                    let signal = controller.signal;
                    var XMLHttpRequest1 = new XMLHttpRequest();
                    fetch(`${URL}/demo/patient/file/load/${PATIENTID}?key=${uniqueFileId}`, {
                            method: "GET",
                            signal,
                        })
                        .then(res => {

                            window.c = res
                            console.log(res)
                            return res.blob();
                        })
                        .then(blob => {


                            const imageFileObj = new File([blob],
                                `${uniqueFileId}`, {
                                    type: blob.type
                                })
                            //console.log(imageFileObj)
                            progress(true, 0, blob.size);

                            load(imageFileObj)


                        })
                        .catch(err => {



                        })

                    return {
                        abort: () => {
                            // User tapped cancel, abort our ongoing actions here
                            controller.abort();
                            // Let FilePond know the request has been cancelled
                            abort();
                        }
                    };
                },

                remove: (uniqueFileId, load, error) => {
                    // Should somehow send `source` to server so server can remove the file with this source
                    files = files.filter(function(ele) {
                        return ele != id + '__' + uniqueFileId;
                    });


                    // Should call the load method when done, no parameters required
                    load();
                },


            },
            onactivatefile: function(file) {
                var win = window.open(URL+"/public/files_pond/" + file
                    .source, '_blank');
                win.focus();
            },
            //files array
            files: load_files,
        }
    );
})

// FilePond.create(document.querySelector('#pintura'), {
//     allowReorder: true,
//     filePosterMaxHeight: 256,

//     // Image Editor plugin properties
//     imageEditor: {
//         // used to create the editor, receives editor configuration, should return an editor instance
//         createEditor: openEditor,

//         // Required, used for reading the image data
//         imageReader: [createDefaultImageReader],

//         // optionally. can leave out when not generating a preview thumbnail and/or output image
//         imageWriter: [
//             // The image writer to use
//             createDefaultImageWriter,
//             // optional image writer instructions, this instructs the image writer to resize the image to match a width of 384 pixels
//             {
//                 targetSize: {
//                     width: 128,
//                 },
//             },

//             /* Uncomment when editing videos, remove above code
//             () =>
//                 createDefaultMediaWriter(
//                     // Generic Media Writer options, passed to image and video writer
//                     {
//                         targetSize: {
//                             width: 400,
//                         },
//                     },
//                     [
//                         // For handling images
//                         createDefaultImageWriter(),

//                         // For handling videos
//                         createDefaultVideoWriter({
//                             // Video writer instructions here
//                             // ...

//                             // Encoder to use
//                             encoder: createMediaStreamEncoder({
//                                 imageStateToCanvas,
//                             }),
//                         }),
//                     ]
//                 ),
//                 */
//         ],

//         // used to generate poster images, runs an editor in the background
//         imageProcessor: processImage,

//         // Pintura Image Editor properties
//         editorOptions: {
//             // pass the editor default configuration options
//             ...getEditorDefaults({
//                 /* Uncomment when editing videos
//                 locale: { ...plugin_trim_locale_en_gb },
//                 */
//             }),

//             // we want a square crop
//             imageCropAspectRatio: 1,
//         },

//         /* uncomment if you've used FilePond with version 6 of Pintura and are loading old file metadata
//         // map legacy data objects to new imageState objects
//         legacyDataToImageState: legacyDataToImageState,
//         */
//     },

//     /* Ucomment when editing videos
//     filePosterFilterItem: (item) => {
//         // We currently cannot create video posters
//         return /image/.test(item.fileType);
//     },
//     */

//     /* Ucomment when editing videos
//     // When editing video's it's advised to use asynchronous uploading, this will trigger video processing on upload instead of on file drop
//     instantUpload: false,
//     server: {
//         // https://pqina.nl/filepond/docs/api/server/#end-points
//     },
//     */

//     /* Uncomment when editing videos
//     imageEditorSupportImage: (file) =>
//         /image/.test(file.type) || /video/.test(file.type),
//     */

//     /* uncomment to preview the resulting file in the document after editing
//     onpreparefile: (fileItem, file) => {
//         const media = document.createElement(
//             /video/.test(file.type) ? 'video' : 'img'
//         );
//         media.controls = true;
//         media.src = URL.createObjectURL(file);
//         document.body.appendChild(media);
//     },
//      */
// });
