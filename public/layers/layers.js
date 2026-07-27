ol.proj.proj4.register(proj4);
//ol.proj.get("EPSG:4326").setExtent([124.103235, -9.427192, 135.816936, -2.524028]);
var wms_layers = [];

var format_BaseKabupaten_Kota_Maluku_0 = new ol.format.GeoJSON();
var features_BaseKabupaten_Kota_Maluku_0 = format_BaseKabupaten_Kota_Maluku_0.readFeatures(json_BaseKabupaten_Kota_Maluku_0, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_BaseKabupaten_Kota_Maluku_0 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_BaseKabupaten_Kota_Maluku_0.addFeatures(features_BaseKabupaten_Kota_Maluku_0);
var lyr_BaseKabupaten_Kota_Maluku_0 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_BaseKabupaten_Kota_Maluku_0, 
                style: style_BaseKabupaten_Kota_Maluku_0,
                popuplayertitle: 'Base Kabupaten_Kota_Maluku',
                interactive: false,
    title: 'Base Kabupaten_Kota_Maluku<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_0.png" /> BURU<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_1.png" /> BURU SELATAN<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_2.png" /> KEPULAUAN ARU<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_3.png" /> KEPULAUAN TANIMBAR<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_4.png" /> KOTA AMBON<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_5.png" /> KOTA TUAL<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_6.png" /> MALUKU BARAT DAYA<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_7.png" /> MALUKU TENGAH<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_8.png" /> MALUKU TENGGARA<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_9.png" /> SERAM BAGIAN BARAT<br />\
    <img src="styles/legend/BaseKabupaten_Kota_Maluku_0_10.png" /> SERAM BAGIAN TIMUR<br />' });
var format_Wilayah_Kec_Maluku_1 = new ol.format.GeoJSON();
var features_Wilayah_Kec_Maluku_1 = format_Wilayah_Kec_Maluku_1.readFeatures(json_Wilayah_Kec_Maluku_1, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Wilayah_Kec_Maluku_1 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Wilayah_Kec_Maluku_1.addFeatures(features_Wilayah_Kec_Maluku_1);
var lyr_Wilayah_Kec_Maluku_1 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Wilayah_Kec_Maluku_1, 
                style: style_Wilayah_Kec_Maluku_1,
                popuplayertitle: 'Wilayah_Kec_Maluku',
                interactive: false,
                title: '<img src="styles/legend/Wilayah_Kec_Maluku_1.png" /> Wilayah_Kec_Maluku'
            });
var format_Kawasan_Kumuh_MBD_2 = new ol.format.GeoJSON();
var features_Kawasan_Kumuh_MBD_2 = format_Kawasan_Kumuh_MBD_2.readFeatures(json_Kawasan_Kumuh_MBD_2, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Kawasan_Kumuh_MBD_2 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Kawasan_Kumuh_MBD_2.addFeatures(features_Kawasan_Kumuh_MBD_2);
var lyr_Kawasan_Kumuh_MBD_2 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Kawasan_Kumuh_MBD_2, 
                style: style_Kawasan_Kumuh_MBD_2,
                popuplayertitle: 'Kawasan_Kumuh_MBD',
                interactive: true,
                title: '<img src="styles/legend/Kawasan_Kumuh_MBD_2.png" /> Kawasan_Kumuh_MBD'
            });
var format_KawasanKumuhKota_Tual_3 = new ol.format.GeoJSON();
var features_KawasanKumuhKota_Tual_3 = format_KawasanKumuhKota_Tual_3.readFeatures(json_KawasanKumuhKota_Tual_3, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_KawasanKumuhKota_Tual_3 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_KawasanKumuhKota_Tual_3.addFeatures(features_KawasanKumuhKota_Tual_3);
var lyr_KawasanKumuhKota_Tual_3 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_KawasanKumuhKota_Tual_3, 
                style: style_KawasanKumuhKota_Tual_3,
                popuplayertitle: 'Kawasan Kumuh Kota_Tual',
                interactive: true,
                title: '<img src="styles/legend/KawasanKumuhKota_Tual_3.png" /> Kawasan Kumuh Kota_Tual'
            });
var format_KawasanKumuhMalteng_4 = new ol.format.GeoJSON();
var features_KawasanKumuhMalteng_4 = format_KawasanKumuhMalteng_4.readFeatures(json_KawasanKumuhMalteng_4, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_KawasanKumuhMalteng_4 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_KawasanKumuhMalteng_4.addFeatures(features_KawasanKumuhMalteng_4);
var lyr_KawasanKumuhMalteng_4 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_KawasanKumuhMalteng_4, 
                style: style_KawasanKumuhMalteng_4,
                popuplayertitle: 'Kawasan Kumuh Malteng',
                interactive: true,
                title: '<img src="styles/legend/KawasanKumuhMalteng_4.png" /> Kawasan Kumuh Malteng'
            });
var format_KawasanKumuh_Seram_Bagian_Barat_5 = new ol.format.GeoJSON();
var features_KawasanKumuh_Seram_Bagian_Barat_5 = format_KawasanKumuh_Seram_Bagian_Barat_5.readFeatures(json_KawasanKumuh_Seram_Bagian_Barat_5, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_KawasanKumuh_Seram_Bagian_Barat_5 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_KawasanKumuh_Seram_Bagian_Barat_5.addFeatures(features_KawasanKumuh_Seram_Bagian_Barat_5);
var lyr_KawasanKumuh_Seram_Bagian_Barat_5 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_KawasanKumuh_Seram_Bagian_Barat_5, 
                style: style_KawasanKumuh_Seram_Bagian_Barat_5,
                popuplayertitle: 'Kawasan Kumuh_Seram_Bagian_Barat',
                interactive: true,
                title: '<img src="styles/legend/KawasanKumuh_Seram_Bagian_Barat_5.png" /> Kawasan Kumuh_Seram_Bagian_Barat'
            });
var format_KawasanKumuh_Seram_Bagian_Timur_6 = new ol.format.GeoJSON();
var features_KawasanKumuh_Seram_Bagian_Timur_6 = format_KawasanKumuh_Seram_Bagian_Timur_6.readFeatures(json_KawasanKumuh_Seram_Bagian_Timur_6, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_KawasanKumuh_Seram_Bagian_Timur_6 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_KawasanKumuh_Seram_Bagian_Timur_6.addFeatures(features_KawasanKumuh_Seram_Bagian_Timur_6);
var lyr_KawasanKumuh_Seram_Bagian_Timur_6 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_KawasanKumuh_Seram_Bagian_Timur_6, 
                style: style_KawasanKumuh_Seram_Bagian_Timur_6,
                popuplayertitle: 'Kawasan Kumuh_Seram_Bagian_Timur',
                interactive: true,
                title: '<img src="styles/legend/KawasanKumuh_Seram_Bagian_Timur_6.png" /> Kawasan Kumuh_Seram_Bagian_Timur'
            });
var format_Kawasan_Kumuh_Buru_7 = new ol.format.GeoJSON();
var features_Kawasan_Kumuh_Buru_7 = format_Kawasan_Kumuh_Buru_7.readFeatures(json_Kawasan_Kumuh_Buru_7, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Kawasan_Kumuh_Buru_7 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Kawasan_Kumuh_Buru_7.addFeatures(features_Kawasan_Kumuh_Buru_7);
var lyr_Kawasan_Kumuh_Buru_7 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Kawasan_Kumuh_Buru_7, 
                style: style_Kawasan_Kumuh_Buru_7,
                popuplayertitle: 'Kawasan_Kumuh_Buru',
                interactive: true,
                title: '<img src="styles/legend/Kawasan_Kumuh_Buru_7.png" /> Kawasan_Kumuh_Buru'
            });
var format_Kawasan_Kumuh_Buru_Selatan_8 = new ol.format.GeoJSON();
var features_Kawasan_Kumuh_Buru_Selatan_8 = format_Kawasan_Kumuh_Buru_Selatan_8.readFeatures(json_Kawasan_Kumuh_Buru_Selatan_8, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Kawasan_Kumuh_Buru_Selatan_8 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Kawasan_Kumuh_Buru_Selatan_8.addFeatures(features_Kawasan_Kumuh_Buru_Selatan_8);
var lyr_Kawasan_Kumuh_Buru_Selatan_8 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Kawasan_Kumuh_Buru_Selatan_8, 
                style: style_Kawasan_Kumuh_Buru_Selatan_8,
                popuplayertitle: 'Kawasan_Kumuh_Buru_Selatan',
                interactive: true,
                title: '<img src="styles/legend/Kawasan_Kumuh_Buru_Selatan_8.png" /> Kawasan_Kumuh_Buru_Selatan'
            });
var format_KawasanKumuh_Maluku_Tenggara_9 = new ol.format.GeoJSON();
var features_KawasanKumuh_Maluku_Tenggara_9 = format_KawasanKumuh_Maluku_Tenggara_9.readFeatures(json_KawasanKumuh_Maluku_Tenggara_9, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_KawasanKumuh_Maluku_Tenggara_9 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_KawasanKumuh_Maluku_Tenggara_9.addFeatures(features_KawasanKumuh_Maluku_Tenggara_9);
var lyr_KawasanKumuh_Maluku_Tenggara_9 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_KawasanKumuh_Maluku_Tenggara_9, 
                style: style_KawasanKumuh_Maluku_Tenggara_9,
                popuplayertitle: 'Kawasan Kumuh_Maluku_Tenggara',
                interactive: true,
                title: '<img src="styles/legend/KawasanKumuh_Maluku_Tenggara_9.png" /> Kawasan Kumuh_Maluku_Tenggara'
            });
var format_Kawasan_Kumuh_Aru_10 = new ol.format.GeoJSON();
var features_Kawasan_Kumuh_Aru_10 = format_Kawasan_Kumuh_Aru_10.readFeatures(json_Kawasan_Kumuh_Aru_10, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Kawasan_Kumuh_Aru_10 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Kawasan_Kumuh_Aru_10.addFeatures(features_Kawasan_Kumuh_Aru_10);
var lyr_Kawasan_Kumuh_Aru_10 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Kawasan_Kumuh_Aru_10, 
                style: style_Kawasan_Kumuh_Aru_10,
                popuplayertitle: 'Kawasan_Kumuh_Aru',
                interactive: true,
                title: '<img src="styles/legend/Kawasan_Kumuh_Aru_10.png" /> Kawasan_Kumuh_Aru'
            });
var format_KawasanKumuhKotaAmbon_11 = new ol.format.GeoJSON();
var features_KawasanKumuhKotaAmbon_11 = format_KawasanKumuhKotaAmbon_11.readFeatures(json_KawasanKumuhKotaAmbon_11, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_KawasanKumuhKotaAmbon_11 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_KawasanKumuhKotaAmbon_11.addFeatures(features_KawasanKumuhKotaAmbon_11);
var lyr_KawasanKumuhKotaAmbon_11 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_KawasanKumuhKotaAmbon_11, 
                style: style_KawasanKumuhKotaAmbon_11,
                popuplayertitle: 'Kawasan Kumuh Kota Ambon',
                interactive: true,
                title: '<img src="styles/legend/KawasanKumuhKotaAmbon_11.png" /> Kawasan Kumuh Kota Ambon'
            });
var format_Ridool_12 = new ol.format.GeoJSON();
var features_Ridool_12 = format_Ridool_12.readFeatures(json_Ridool_12, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Ridool_12 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Ridool_12.addFeatures(features_Ridool_12);
var lyr_Ridool_12 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Ridool_12, 
                style: style_Ridool_12,
                popuplayertitle: 'Ridool',
                interactive: true,
                title: '<img src="styles/legend/Ridool_12.png" /> Ridool'
            });
var format_Ritabel_13 = new ol.format.GeoJSON();
var features_Ritabel_13 = format_Ritabel_13.readFeatures(json_Ritabel_13, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Ritabel_13 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Ritabel_13.addFeatures(features_Ritabel_13);
var lyr_Ritabel_13 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Ritabel_13, 
                style: style_Ritabel_13,
                popuplayertitle: 'Ritabel',
                interactive: true,
                title: '<img src="styles/legend/Ritabel_13.png" /> Ritabel'
            });
var format_Saumlaki_14 = new ol.format.GeoJSON();
var features_Saumlaki_14 = format_Saumlaki_14.readFeatures(json_Saumlaki_14, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Saumlaki_14 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Saumlaki_14.addFeatures(features_Saumlaki_14);
var lyr_Saumlaki_14 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Saumlaki_14, 
                style: style_Saumlaki_14,
                popuplayertitle: 'Saumlaki',
                interactive: true,
                title: '<img src="styles/legend/Saumlaki_14.png" /> Saumlaki'
            });
var format_MalukuTengah_15 = new ol.format.GeoJSON();
var features_MalukuTengah_15 = format_MalukuTengah_15.readFeatures(json_MalukuTengah_15, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_MalukuTengah_15 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_MalukuTengah_15.addFeatures(features_MalukuTengah_15);
cluster_MalukuTengah_15 = new ol.source.Cluster({
  distance: 30,
  source: jsonSource_MalukuTengah_15
});
var lyr_MalukuTengah_15 = new ol.layer.Vector({
                declutter: false,
                source:cluster_MalukuTengah_15, 
                style: style_MalukuTengah_15,
                popuplayertitle: 'Maluku Tengah',
                interactive: true,
                title: '<img src="styles/legend/MalukuTengah_15.png" /> Maluku Tengah'
            });
var format_BuruSelatan_16 = new ol.format.GeoJSON();
var features_BuruSelatan_16 = format_BuruSelatan_16.readFeatures(json_BuruSelatan_16, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_BuruSelatan_16 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_BuruSelatan_16.addFeatures(features_BuruSelatan_16);
cluster_BuruSelatan_16 = new ol.source.Cluster({
  distance: 30,
  source: jsonSource_BuruSelatan_16
});
var lyr_BuruSelatan_16 = new ol.layer.Vector({
                declutter: false,
                source:cluster_BuruSelatan_16, 
                style: style_BuruSelatan_16,
                popuplayertitle: 'Buru Selatan',
                interactive: true,
                title: '<img src="styles/legend/BuruSelatan_16.png" /> Buru Selatan'
            });
var format_Kota_Ambon_17 = new ol.format.GeoJSON();
var features_Kota_Ambon_17 = format_Kota_Ambon_17.readFeatures(json_Kota_Ambon_17, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Kota_Ambon_17 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Kota_Ambon_17.addFeatures(features_Kota_Ambon_17);
cluster_Kota_Ambon_17 = new ol.source.Cluster({
  distance: 30,
  source: jsonSource_Kota_Ambon_17
});
var lyr_Kota_Ambon_17 = new ol.layer.Vector({
                declutter: false,
                source:cluster_Kota_Ambon_17, 
                style: style_Kota_Ambon_17,
                popuplayertitle: 'Kota_Ambon',
                interactive: true,
                title: '<img src="styles/legend/Kota_Ambon_17.png" /> Kota_Ambon'
            });
var format_SeramBagianBarat_18 = new ol.format.GeoJSON();
var features_SeramBagianBarat_18 = format_SeramBagianBarat_18.readFeatures(json_SeramBagianBarat_18, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_SeramBagianBarat_18 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_SeramBagianBarat_18.addFeatures(features_SeramBagianBarat_18);
cluster_SeramBagianBarat_18 = new ol.source.Cluster({
  distance: 30,
  source: jsonSource_SeramBagianBarat_18
});
var lyr_SeramBagianBarat_18 = new ol.layer.Vector({
                declutter: false,
                source:cluster_SeramBagianBarat_18, 
                style: style_SeramBagianBarat_18,
                popuplayertitle: 'Seram Bagian Barat',
                interactive: true,
                title: '<img src="styles/legend/SeramBagianBarat_18.png" /> Seram Bagian Barat'
            });
var format_SeramBagianTimur_19 = new ol.format.GeoJSON();
var features_SeramBagianTimur_19 = format_SeramBagianTimur_19.readFeatures(json_SeramBagianTimur_19, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_SeramBagianTimur_19 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_SeramBagianTimur_19.addFeatures(features_SeramBagianTimur_19);
cluster_SeramBagianTimur_19 = new ol.source.Cluster({
  distance: 30,
  source: jsonSource_SeramBagianTimur_19
});
var lyr_SeramBagianTimur_19 = new ol.layer.Vector({
                declutter: false,
                source:cluster_SeramBagianTimur_19, 
                style: style_SeramBagianTimur_19,
                popuplayertitle: 'Seram Bagian Timur',
                interactive: true,
                title: '<img src="styles/legend/SeramBagianTimur_19.png" /> Seram Bagian Timur'
            });
var group_PROGRAMMBBR2025 = new ol.layer.Group({
                                layers: [lyr_MalukuTengah_15,lyr_BuruSelatan_16,lyr_Kota_Ambon_17,lyr_SeramBagianBarat_18,lyr_SeramBagianTimur_19,],
                                fold: 'open',
                                title: 'PROGRAM MBBR 2025'});
var group_KawasanKumuhKKT = new ol.layer.Group({
                                layers: [lyr_Ridool_12,lyr_Ritabel_13,lyr_Saumlaki_14,],
                                fold: 'close',
                                title: 'Kawasan Kumuh KKT'});
var group_PETAKAWASANKUMUH2024 = new ol.layer.Group({
                                layers: [lyr_Kawasan_Kumuh_MBD_2,lyr_KawasanKumuhKota_Tual_3,lyr_KawasanKumuhMalteng_4,lyr_KawasanKumuh_Seram_Bagian_Barat_5,lyr_KawasanKumuh_Seram_Bagian_Timur_6,lyr_Kawasan_Kumuh_Buru_7,lyr_Kawasan_Kumuh_Buru_Selatan_8,lyr_KawasanKumuh_Maluku_Tenggara_9,lyr_Kawasan_Kumuh_Aru_10,lyr_KawasanKumuhKotaAmbon_11,],
                                fold: 'open',
                                title: 'PETA KAWASAN KUMUH 2024'});

lyr_BaseKabupaten_Kota_Maluku_0.setVisible(true);lyr_Wilayah_Kec_Maluku_1.setVisible(true);lyr_Kawasan_Kumuh_MBD_2.setVisible(true);lyr_KawasanKumuhKota_Tual_3.setVisible(true);lyr_KawasanKumuhMalteng_4.setVisible(true);lyr_KawasanKumuh_Seram_Bagian_Barat_5.setVisible(true);lyr_KawasanKumuh_Seram_Bagian_Timur_6.setVisible(true);lyr_Kawasan_Kumuh_Buru_7.setVisible(true);lyr_Kawasan_Kumuh_Buru_Selatan_8.setVisible(true);lyr_KawasanKumuh_Maluku_Tenggara_9.setVisible(true);lyr_Kawasan_Kumuh_Aru_10.setVisible(true);lyr_KawasanKumuhKotaAmbon_11.setVisible(true);lyr_Ridool_12.setVisible(true);lyr_Ritabel_13.setVisible(true);lyr_Saumlaki_14.setVisible(true);lyr_MalukuTengah_15.setVisible(true);lyr_BuruSelatan_16.setVisible(true);lyr_Kota_Ambon_17.setVisible(true);lyr_SeramBagianBarat_18.setVisible(true);lyr_SeramBagianTimur_19.setVisible(true);
var layersList = [lyr_BaseKabupaten_Kota_Maluku_0,lyr_Wilayah_Kec_Maluku_1,group_PETAKAWASANKUMUH2024,group_KawasanKumuhKKT,group_PROGRAMMBBR2025];
lyr_BaseKabupaten_Kota_Maluku_0.set('fieldAliases', {'TARGET_FID': 'TARGET_FID', 'Shape_Leng': 'Shape_Leng', 'SUMBER': 'SUMBER', 'Kode_Kab_K': 'Kode_Kab_K', 'objectid': 'objectid', 'no_prop': 'no_prop', 'no_kab': 'no_kab', 'kode_prov_': 'kode_prov_', 'kode_kab_s': 'kode_kab_s', 'nama_prop_': 'nama_prop_', 'nama_kab_s': 'nama_kab_s', 'jumlah_kec': 'jumlah_kec', 'jumlah_des': 'jumlah_des', 'jumlah_kel': 'jumlah_kel', 'jumlah_pen': 'jumlah_pen', 'jumlah_kk': 'jumlah_kk', 'luas_wilay': 'luas_wilay', 'kepadatan_': 'kepadatan_', 'Shape_Le_1': 'Shape_Le_1', 'Shape_Area': 'Shape_Area', });
lyr_Wilayah_Kec_Maluku_1.set('fieldAliases', {'objectid': 'objectid', 'kode_siak': 'kode_siak', 'nama_siak': 'nama_siak', 'luas': 'luas', 'objectid_2': 'objectid_2', 'no_prop': 'no_prop', 'no_kab': 'no_kab', 'no_kec': 'no_kec', 'kode_prov_': 'kode_prov_', 'kode_kab_s': 'kode_kab_s', 'kode_kec_s': 'kode_kec_s', 'nama_prop_': 'nama_prop_', 'nama_kab_s': 'nama_kab_s', 'nama_kec_s': 'nama_kec_s', 'jumlah_des': 'jumlah_des', 'luas_wilay': 'luas_wilay', 'Shape_Leng': 'Shape_Leng', 'Shape_Area': 'Shape_Area', });
lyr_Kawasan_Kumuh_MBD_2.set('fieldAliases', {'Kawasan': 'Kawasan', 'Provinsi': 'Provinsi', 'Kode_Prov': 'Kode_Prov', 'Kab_Kota': 'Kab_Kota', 'Kode_Kab': 'Kode_Kab', 'Kecamatan': 'Kecamatan', 'Kode_Kec': 'Kode_Kec', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Kode_RT_RW': 'Kode_RT_RW', 'Luas_Kumuh': 'Luas_Kumuh', 'Skor_Kumuh': 'Skor_Kumuh', 'Smber_Data': 'Smber_Data', });
lyr_KawasanKumuhKota_Tual_3.set('fieldAliases', {'OBJECTID': 'OBJECTID', 'Provinsi': 'Provinsi', 'Kode_Prov': 'Kode_Prov', 'Kab_Kota': 'Kab_Kota', 'Kode_Kab': 'Kode_Kab', 'Kecamatan': 'Kecamatan', 'Kode_Kec': 'Kode_Kec', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'RW': 'RW', 'RT': 'RT', 'Kode_RTRW': 'Kode_RTRW', 'Label': 'Label', 'LUASANBARU': 'LUASANBARU', 'Kawasan': 'Kawasan', 'Skor_Kumuh': 'Skor_Kumuh', 'Kekumuhan': 'Kekumuhan', 'Smbr_Data': 'Smbr_Data', });
lyr_KawasanKumuhMalteng_4.set('fieldAliases', {'Id': 'Id', 'Kecamatan': 'Kecamatan', 'Desa': 'Desa', 'Deliniasi': 'Deliniasi', 'Jml_Pendud': 'Jml_Pendud', 'Kepa_datan': 'Kepa_datan', 'Kekumuhan': 'Kekumuhan', 'Nilai': 'Nilai', 'Luas': 'Luas', 'X': 'X', 'Y': 'Y', 'Luasanbaru': 'Luasanbaru', 'Pembanding': 'Pembanding', });
lyr_KawasanKumuh_Seram_Bagian_Barat_5.set('fieldAliases', {'Id': 'Id', 'Provinsi': 'Provinsi', 'Kode_Prov': 'Kode_Prov', 'Kab_Kota': 'Kab_Kota', 'Kode_Kab': 'Kode_Kab', 'Kecamatan': 'Kecamatan', 'Kode_Kec': 'Kode_Kec', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Kode_RT_RW': 'Kode_RT_RW', 'Luas_Kumuh': 'Luas_Kumuh', 'Skor_Kumuh': 'Skor_Kumuh', 'Smbr_Data': 'Smbr_Data', 'X': 'X', 'Y': 'Y', 'Kawasan': 'Kawasan', });
lyr_KawasanKumuh_Seram_Bagian_Timur_6.set('fieldAliases', {'Id': 'Id', 'Provinsi': 'Provinsi', 'Kode_Prov': 'Kode_Prov', 'Kab_Kota': 'Kab_Kota', 'Kode_Kab': 'Kode_Kab', 'Kecamatan': 'Kecamatan', 'Kode_Kec': 'Kode_Kec', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Kode_RT_RW': 'Kode_RT_RW', 'Luas_Kumuh': 'Luas_Kumuh', 'Skor_Kumuh': 'Skor_Kumuh', 'Kawasan': 'Kawasan', 'Smbr_Data': 'Smbr_Data', 'X': 'X', 'Y': 'Y', });
lyr_Kawasan_Kumuh_Buru_7.set('fieldAliases', {'Id': 'Id', 'Provinsi': 'Provinsi', 'Kode_Prov': 'Kode_Prov', 'Kab_Kota': 'Kab_Kota', 'Kode_Kab': 'Kode_Kab', 'Kecamatan': 'Kecamatan', 'Kode_Kec': 'Kode_Kec', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Kode_RT_RW': 'Kode_RT_RW', 'Luas_Kumuh': 'Luas_Kumuh', 'Skor_Kumuh': 'Skor_Kumuh', 'Kawasan': 'Kawasan', 'Smber_Data': 'Smber_Data', 'X': 'X', 'Y': 'Y', });
lyr_Kawasan_Kumuh_Buru_Selatan_8.set('fieldAliases', {'Id': 'Id', 'Kawasan': 'Kawasan', 'Provinsi': 'Provinsi', 'Kode_Prov': 'Kode_Prov', 'Kab_Kota': 'Kab_Kota', 'Kode_Kab': 'Kode_Kab', 'Kecamatan': 'Kecamatan', 'Kode_Kec': 'Kode_Kec', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Kode_RT_RW': 'Kode_RT_RW', 'Luas_Kumuh': 'Luas_Kumuh', 'Skor_Kumuh': 'Skor_Kumuh', 'Smber_Data': 'Smber_Data', 'X': 'X', 'Y': 'Y', });
lyr_KawasanKumuh_Maluku_Tenggara_9.set('fieldAliases', {'NAME': 'NAME', 'Provinsi': 'Provinsi', 'Kode_Prov': 'Kode_Prov', 'Kab_Kota': 'Kab_Kota', 'Kode_Kab': 'Kode_Kab', 'Kecamatan': 'Kecamatan', 'Kode_Kec': 'Kode_Kec', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Kode_RT_RW': 'Kode_RT_RW', 'Luas_Kumuh': 'Luas_Kumuh', 'Skor_Kumuh': 'Skor_Kumuh', 'Smbr_Data': 'Smbr_Data', 'Kawasan': 'Kawasan', 'Bujur': 'Bujur', 'Lintang': 'Lintang', });
lyr_Kawasan_Kumuh_Aru_10.set('fieldAliases', {'Provinsi': 'Provinsi', 'Kode_Prov': 'Kode_Prov', 'Kab_Kota': 'Kab_Kota', 'Kode_Kab': 'Kode_Kab', 'Kecamatan': 'Kecamatan', 'Kode_Kec': 'Kode_Kec', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Kode_RT_RW': 'Kode_RT_RW', 'Luas_Kumuh': 'Luas_Kumuh', 'Skor_Kumuh': 'Skor_Kumuh', 'Smbr_Data': 'Smbr_Data', 'X': 'X', 'Y': 'Y', 'Kawasan': 'Kawasan', });
lyr_KawasanKumuhKotaAmbon_11.set('fieldAliases', {'Prov': 'Prov', 'Kode_Prov': 'Kode_Prov', 'Kab_Kota': 'Kab_Kota', 'Kode_Kab': 'Kode_Kab', 'Kecamatan': 'Kecamatan', 'Kode_Kec': 'Kode_Kec', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Basis': 'Basis', 'Sumber': 'Sumber', 'luasan': 'luasan', 'Nama_Kwsan': 'Nama_Kwsan', 'LUASANFIX': 'LUASANFIX', });
lyr_Ridool_12.set('fieldAliases', {'Prov': 'Prov', 'Kab_Kota': 'Kab_Kota', 'Kecamatan': 'Kecamatan', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Basis': 'Basis', 'Luas': 'Luas', 'Nama_Kawas': 'Nama_Kawas', 'Luasanbaru': 'Luasanbaru', });
lyr_Ritabel_13.set('fieldAliases', {'Prov': 'Prov', 'Kab_Kota': 'Kab_Kota', 'Kecamatan': 'Kecamatan', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Basis': 'Basis', 'Luas': 'Luas', 'Nama_Kawas': 'Nama_Kawas', 'Luasanbaru': 'Luasanbaru', });
lyr_Saumlaki_14.set('fieldAliases', {'Prov': 'Prov', 'Kab_Kota': 'Kab_Kota', 'Kecamatan': 'Kecamatan', 'Kelurahan': 'Kelurahan', 'Kode_Kel': 'Kode_Kel', 'Basis': 'Basis', 'Luasan': 'Luasan', 'Nama_Kawas': 'Nama_Kawas', 'Luasan_202': 'Luasan_202', });
lyr_MalukuTengah_15.set('fieldAliases', {'No': 'No', 'Tanggal_Up': 'Tanggal_Up', 'Tanggal_Mo': 'Tanggal_Mo', 'Nama_Penda': 'Nama_Penda', 'Nama_Pener': 'Nama_Pener', 'Kabupaten_': 'Kabupaten_', 'Nama_Desa': 'Nama_Desa', 'Nama_Toko': 'Nama_Toko', 'Jumlah_Bia': 'Jumlah_Bia', 'Presentasi': 'Presentasi', 'Sisa__Rp__': 'Sisa__Rp__', 'Jumlah_B_1': 'Jumlah_B_1', 'Presenta_1': 'Presenta_1', 'Sisa__Rp_1': 'Sisa__Rp_1', 'Latitude': 'Latitude', 'Longitude': 'Longitude', 'Presenta_2': 'Presenta_2', 'Photo': 'Photo', 'Photo Sebe': 'Photo Sebe', });
lyr_BuruSelatan_16.set('fieldAliases', {'No': 'No', 'Tanggal_Up': 'Tanggal_Up', 'Tanggal_Mo': 'Tanggal_Mo', 'Nama_Penda': 'Nama_Penda', 'Nama_Pener': 'Nama_Pener', 'Kabupaten_': 'Kabupaten_', 'Nama_Desa': 'Nama_Desa', 'Nama_Toko': 'Nama_Toko', 'Jumlah_Bia': 'Jumlah_Bia', 'Presentasi': 'Presentasi', 'Sisa__Rp__': 'Sisa__Rp__', 'Jumlah_B_1': 'Jumlah_B_1', 'Presenta_1': 'Presenta_1', 'Sisa__Rp_1': 'Sisa__Rp_1', 'Latitude': 'Latitude', 'Longitude': 'Longitude', 'Presenta_2': 'Presenta_2', 'F18': 'F18', 'F19': 'F19', 'F20': 'F20', 'F21': 'F21', 'Before': 'Before', });
lyr_Kota_Ambon_17.set('fieldAliases', {'No': 'No', 'Tanggal_Up': 'Tanggal_Up', 'Latitude': 'Latitude', 'Longitude': 'Longitude', 'Tanggal_Mo': 'Tanggal_Mo', 'Nama_Penda': 'Nama_Penda', 'Nama_Pener': 'Nama_Pener', 'Kabupaten_': 'Kabupaten_', 'Nama_Desa': 'Nama_Desa', 'Nama_Toko': 'Nama_Toko', 'Jumlah_Bia': 'Jumlah_Bia', 'Presentasi': 'Presentasi', 'Sisa__Rp__': 'Sisa__Rp__', 'Jumlah_B_1': 'Jumlah_B_1', 'Presenta_1': 'Presenta_1', 'Sisa__Rp_1': 'Sisa__Rp_1', 'Latitude1': 'Latitude1', 'Longitude1': 'Longitude1', 'Presenta_2': 'Presenta_2', 'Before': 'Before', 'After': 'After', 'PHOTO1': 'PHOTO1', 'PHOTO2': 'PHOTO2', });
lyr_SeramBagianBarat_18.set('fieldAliases', {'No': 'No', 'Tanggal_Up': 'Tanggal_Up', 'Tanggal_Mo': 'Tanggal_Mo', 'Nama_Penda': 'Nama_Penda', 'Nama_Pener': 'Nama_Pener', 'Kabupaten_': 'Kabupaten_', 'Nama_Desa': 'Nama_Desa', 'Nama_Toko': 'Nama_Toko', 'Jumlah_Bia': 'Jumlah_Bia', 'Presentasi': 'Presentasi', 'Sisa__Rp__': 'Sisa__Rp__', 'Jumlah_B_1': 'Jumlah_B_1', 'Presenta_1': 'Presenta_1', 'Sisa__Rp_1': 'Sisa__Rp_1', 'Latitude': 'Latitude', 'Longitude': 'Longitude', 'Presenta_2': 'Presenta_2', 'F18': 'F18', 'F19': 'F19', 'F20': 'F20', });
lyr_SeramBagianTimur_19.set('fieldAliases', {'No': 'No', 'Tanggal_Up': 'Tanggal_Up', 'Tanggal_Mo': 'Tanggal_Mo', 'Nama_Penda': 'Nama_Penda', 'Nama_Pener': 'Nama_Pener', 'Kabupaten_': 'Kabupaten_', 'Nama_Desa': 'Nama_Desa', 'Nama_Toko': 'Nama_Toko', 'Jumlah_Bia': 'Jumlah_Bia', 'Presentasi': 'Presentasi', 'Sisa__Rp__': 'Sisa__Rp__', 'Jumlah_B_1': 'Jumlah_B_1', 'Presenta_1': 'Presenta_1', 'Sisa__Rp_1': 'Sisa__Rp_1', 'Latitude': 'Latitude', 'Longitude': 'Longitude', 'Presenta_2': 'Presenta_2', });
lyr_BaseKabupaten_Kota_Maluku_0.set('fieldImages', {'TARGET_FID': 'TextEdit', 'Shape_Leng': 'TextEdit', 'SUMBER': 'TextEdit', 'Kode_Kab_K': 'TextEdit', 'objectid': 'TextEdit', 'no_prop': 'TextEdit', 'no_kab': 'TextEdit', 'kode_prov_': 'TextEdit', 'kode_kab_s': 'TextEdit', 'nama_prop_': 'TextEdit', 'nama_kab_s': 'TextEdit', 'jumlah_kec': 'TextEdit', 'jumlah_des': 'TextEdit', 'jumlah_kel': 'TextEdit', 'jumlah_pen': 'TextEdit', 'jumlah_kk': 'TextEdit', 'luas_wilay': 'TextEdit', 'kepadatan_': 'TextEdit', 'Shape_Le_1': 'TextEdit', 'Shape_Area': 'TextEdit', });
lyr_Wilayah_Kec_Maluku_1.set('fieldImages', {'objectid': 'TextEdit', 'kode_siak': 'TextEdit', 'nama_siak': 'TextEdit', 'luas': 'TextEdit', 'objectid_2': 'TextEdit', 'no_prop': 'TextEdit', 'no_kab': 'TextEdit', 'no_kec': 'TextEdit', 'kode_prov_': 'TextEdit', 'kode_kab_s': 'TextEdit', 'kode_kec_s': 'TextEdit', 'nama_prop_': 'TextEdit', 'nama_kab_s': 'TextEdit', 'nama_kec_s': 'TextEdit', 'jumlah_des': 'TextEdit', 'luas_wilay': 'TextEdit', 'Shape_Leng': 'TextEdit', 'Shape_Area': 'TextEdit', });
lyr_Kawasan_Kumuh_MBD_2.set('fieldImages', {'Kawasan': 'TextEdit', 'Provinsi': 'TextEdit', 'Kode_Prov': 'TextEdit', 'Kab_Kota': 'TextEdit', 'Kode_Kab': 'TextEdit', 'Kecamatan': 'TextEdit', 'Kode_Kec': 'TextEdit', 'Kelurahan': 'TextEdit', 'Kode_Kel': 'TextEdit', 'Kode_RT_RW': 'TextEdit', 'Luas_Kumuh': 'TextEdit', 'Skor_Kumuh': 'TextEdit', 'Smber_Data': 'TextEdit', });
lyr_KawasanKumuhKota_Tual_3.set('fieldImages', {'OBJECTID': 'TextEdit', 'Provinsi': 'TextEdit', 'Kode_Prov': 'TextEdit', 'Kab_Kota': 'TextEdit', 'Kode_Kab': 'TextEdit', 'Kecamatan': 'TextEdit', 'Kode_Kec': 'TextEdit', 'Kelurahan': 'TextEdit', 'Kode_Kel': 'TextEdit', 'RW': 'TextEdit', 'RT': 'TextEdit', 'Kode_RTRW': 'TextEdit', 'Label': 'TextEdit', 'LUASANBARU': 'TextEdit', 'Kawasan': 'TextEdit', 'Skor_Kumuh': 'TextEdit', 'Kekumuhan': 'TextEdit', 'Smbr_Data': 'TextEdit', });
lyr_KawasanKumuhMalteng_4.set('fieldImages', {'Id': 'Range', 'Kecamatan': 'TextEdit', 'Desa': 'TextEdit', 'Deliniasi': 'TextEdit', 'Jml_Pendud': 'TextEdit', 'Kepa_datan': 'TextEdit', 'Kekumuhan': 'TextEdit', 'Nilai': 'TextEdit', 'Luas': 'TextEdit', 'X': 'TextEdit', 'Y': 'TextEdit', 'Luasanbaru': 'TextEdit', 'Pembanding': 'TextEdit', });
lyr_KawasanKumuh_Seram_Bagian_Barat_5.set('fieldImages', {'Id': 'TextEdit', 'Provinsi': 'TextEdit', 'Kode_Prov': 'TextEdit', 'Kab_Kota': 'TextEdit', 'Kode_Kab': 'TextEdit', 'Kecamatan': 'TextEdit', 'Kode_Kec': 'TextEdit', 'Kelurahan': 'TextEdit', 'Kode_Kel': 'TextEdit', 'Kode_RT_RW': 'TextEdit', 'Luas_Kumuh': 'TextEdit', 'Skor_Kumuh': 'TextEdit', 'Smbr_Data': 'TextEdit', 'X': 'TextEdit', 'Y': 'TextEdit', 'Kawasan': 'TextEdit', });
lyr_KawasanKumuh_Seram_Bagian_Timur_6.set('fieldImages', {'Id': 'Range', 'Provinsi': 'TextEdit', 'Kode_Prov': 'TextEdit', 'Kab_Kota': 'TextEdit', 'Kode_Kab': 'TextEdit', 'Kecamatan': 'TextEdit', 'Kode_Kec': 'TextEdit', 'Kelurahan': 'TextEdit', 'Kode_Kel': 'TextEdit', 'Kode_RT_RW': 'TextEdit', 'Luas_Kumuh': 'TextEdit', 'Skor_Kumuh': 'TextEdit', 'Kawasan': 'TextEdit', 'Smbr_Data': 'TextEdit', 'X': 'TextEdit', 'Y': 'TextEdit', });
lyr_Kawasan_Kumuh_Buru_7.set('fieldImages', {'Id': 'Range', 'Provinsi': 'TextEdit', 'Kode_Prov': 'TextEdit', 'Kab_Kota': 'TextEdit', 'Kode_Kab': 'TextEdit', 'Kecamatan': 'TextEdit', 'Kode_Kec': 'TextEdit', 'Kelurahan': 'TextEdit', 'Kode_Kel': 'TextEdit', 'Kode_RT_RW': 'TextEdit', 'Luas_Kumuh': 'TextEdit', 'Skor_Kumuh': 'TextEdit', 'Kawasan': 'TextEdit', 'Smber_Data': 'TextEdit', 'X': 'TextEdit', 'Y': 'TextEdit', });
lyr_Kawasan_Kumuh_Buru_Selatan_8.set('fieldImages', {'Id': 'Range', 'Kawasan': 'TextEdit', 'Provinsi': 'TextEdit', 'Kode_Prov': 'TextEdit', 'Kab_Kota': 'TextEdit', 'Kode_Kab': 'TextEdit', 'Kecamatan': 'TextEdit', 'Kode_Kec': 'TextEdit', 'Kelurahan': 'TextEdit', 'Kode_Kel': 'TextEdit', 'Kode_RT_RW': 'TextEdit', 'Luas_Kumuh': 'TextEdit', 'Skor_Kumuh': 'TextEdit', 'Smber_Data': 'TextEdit', 'X': 'TextEdit', 'Y': 'TextEdit', });
lyr_KawasanKumuh_Maluku_Tenggara_9.set('fieldImages', {'NAME': 'TextEdit', 'Provinsi': 'TextEdit', 'Kode_Prov': 'TextEdit', 'Kab_Kota': 'TextEdit', 'Kode_Kab': 'TextEdit', 'Kecamatan': 'TextEdit', 'Kode_Kec': 'TextEdit', 'Kelurahan': 'TextEdit', 'Kode_Kel': 'TextEdit', 'Kode_RT_RW': 'TextEdit', 'Luas_Kumuh': 'TextEdit', 'Skor_Kumuh': 'TextEdit', 'Smbr_Data': 'TextEdit', 'Kawasan': 'TextEdit', 'Bujur': 'TextEdit', 'Lintang': 'TextEdit', });
lyr_Kawasan_Kumuh_Aru_10.set('fieldImages', {'Provinsi': 'TextEdit', 'Kode_Prov': 'TextEdit', 'Kab_Kota': 'TextEdit', 'Kode_Kab': 'TextEdit', 'Kecamatan': 'TextEdit', 'Kode_Kec': 'TextEdit', 'Kelurahan': 'TextEdit', 'Kode_Kel': 'TextEdit', 'Kode_RT_RW': 'TextEdit', 'Luas_Kumuh': 'TextEdit', 'Skor_Kumuh': 'TextEdit', 'Smbr_Data': 'TextEdit', 'X': 'TextEdit', 'Y': 'TextEdit', 'Kawasan': 'TextEdit', });
lyr_KawasanKumuhKotaAmbon_11.set('fieldImages', {'Prov': 'TextEdit', 'Kode_Prov': 'TextEdit', 'Kab_Kota': 'TextEdit', 'Kode_Kab': 'TextEdit', 'Kecamatan': 'TextEdit', 'Kode_Kec': 'TextEdit', 'Kelurahan': 'TextEdit', 'Kode_Kel': 'TextEdit', 'Basis': 'TextEdit', 'Sumber': 'TextEdit', 'luasan': 'TextEdit', 'Nama_Kwsan': 'TextEdit', 'LUASANFIX': 'TextEdit', });
lyr_Ridool_12.set('fieldImages', {'Prov': '', 'Kab_Kota': '', 'Kecamatan': '', 'Kelurahan': '', 'Kode_Kel': '', 'Basis': '', 'Luas': '', 'Nama_Kawas': '', 'Luasanbaru': '', });
lyr_Ritabel_13.set('fieldImages', {'Prov': '', 'Kab_Kota': '', 'Kecamatan': '', 'Kelurahan': '', 'Kode_Kel': '', 'Basis': '', 'Luas': '', 'Nama_Kawas': '', 'Luasanbaru': '', });
lyr_Saumlaki_14.set('fieldImages', {'Prov': '', 'Kab_Kota': '', 'Kecamatan': '', 'Kelurahan': '', 'Kode_Kel': '', 'Basis': '', 'Luasan': '', 'Nama_Kawas': '', 'Luasan_202': '', });
lyr_MalukuTengah_15.set('fieldImages', {'No': 'TextEdit', 'Tanggal_Up': 'DateTime', 'Tanggal_Mo': 'TextEdit', 'Nama_Penda': 'TextEdit', 'Nama_Pener': 'TextEdit', 'Kabupaten_': 'TextEdit', 'Nama_Desa': 'TextEdit', 'Nama_Toko': 'TextEdit', 'Jumlah_Bia': 'TextEdit', 'Presentasi': 'TextEdit', 'Sisa__Rp__': 'TextEdit', 'Jumlah_B_1': 'TextEdit', 'Presenta_1': 'TextEdit', 'Sisa__Rp_1': 'TextEdit', 'Latitude': 'TextEdit', 'Longitude': 'TextEdit', 'Presenta_2': 'TextEdit', 'Photo': 'TextEdit', 'Photo Sebe': 'TextEdit', });
lyr_BuruSelatan_16.set('fieldImages', {'No': 'TextEdit', 'Tanggal_Up': 'TextEdit', 'Tanggal_Mo': 'TextEdit', 'Nama_Penda': 'TextEdit', 'Nama_Pener': 'TextEdit', 'Kabupaten_': 'TextEdit', 'Nama_Desa': 'TextEdit', 'Nama_Toko': 'TextEdit', 'Jumlah_Bia': 'TextEdit', 'Presentasi': 'TextEdit', 'Sisa__Rp__': 'TextEdit', 'Jumlah_B_1': 'TextEdit', 'Presenta_1': 'TextEdit', 'Sisa__Rp_1': 'TextEdit', 'Latitude': 'TextEdit', 'Longitude': 'TextEdit', 'Presenta_2': 'TextEdit', 'F18': 'TextEdit', 'F19': 'TextEdit', 'F20': 'TextEdit', 'F21': 'TextEdit', 'Before': 'ExternalResource', });
lyr_Kota_Ambon_17.set('fieldImages', {'No': 'TextEdit', 'Tanggal_Up': 'DateTime', 'Latitude': 'TextEdit', 'Longitude': 'TextEdit', 'Tanggal_Mo': 'DateTime', 'Nama_Penda': 'TextEdit', 'Nama_Pener': 'TextEdit', 'Kabupaten_': 'TextEdit', 'Nama_Desa': 'TextEdit', 'Nama_Toko': 'TextEdit', 'Jumlah_Bia': 'TextEdit', 'Presentasi': 'TextEdit', 'Sisa__Rp__': 'TextEdit', 'Jumlah_B_1': 'TextEdit', 'Presenta_1': 'TextEdit', 'Sisa__Rp_1': 'TextEdit', 'Latitude1': 'TextEdit', 'Longitude1': 'TextEdit', 'Presenta_2': 'TextEdit', 'Before': 'ExternalResource', 'After': 'TextEdit', 'PHOTO1': 'ExternalResource', 'PHOTO2': 'ExternalResource', });
lyr_SeramBagianBarat_18.set('fieldImages', {'No': 'TextEdit', 'Tanggal_Up': 'DateTime', 'Tanggal_Mo': 'DateTime', 'Nama_Penda': 'TextEdit', 'Nama_Pener': 'TextEdit', 'Kabupaten_': 'TextEdit', 'Nama_Desa': 'TextEdit', 'Nama_Toko': 'TextEdit', 'Jumlah_Bia': 'TextEdit', 'Presentasi': 'TextEdit', 'Sisa__Rp__': 'TextEdit', 'Jumlah_B_1': 'TextEdit', 'Presenta_1': 'TextEdit', 'Sisa__Rp_1': 'TextEdit', 'Latitude': 'TextEdit', 'Longitude': 'TextEdit', 'Presenta_2': 'TextEdit', 'F18': 'TextEdit', 'F19': 'TextEdit', 'F20': 'TextEdit', });
lyr_SeramBagianTimur_19.set('fieldImages', {'No': 'TextEdit', 'Tanggal_Up': 'DateTime', 'Tanggal_Mo': 'DateTime', 'Nama_Penda': 'TextEdit', 'Nama_Pener': 'TextEdit', 'Kabupaten_': 'TextEdit', 'Nama_Desa': 'TextEdit', 'Nama_Toko': 'TextEdit', 'Jumlah_Bia': 'TextEdit', 'Presentasi': 'TextEdit', 'Sisa__Rp__': 'TextEdit', 'Jumlah_B_1': 'TextEdit', 'Presenta_1': 'TextEdit', 'Sisa__Rp_1': 'TextEdit', 'Latitude': 'TextEdit', 'Longitude': 'TextEdit', 'Presenta_2': 'TextEdit', });
lyr_BaseKabupaten_Kota_Maluku_0.set('fieldLabels', {'TARGET_FID': 'no label', 'Shape_Leng': 'no label', 'SUMBER': 'no label', 'Kode_Kab_K': 'no label', 'objectid': 'no label', 'no_prop': 'no label', 'no_kab': 'no label', 'kode_prov_': 'no label', 'kode_kab_s': 'no label', 'nama_prop_': 'no label', 'nama_kab_s': 'no label', 'jumlah_kec': 'no label', 'jumlah_des': 'no label', 'jumlah_kel': 'no label', 'jumlah_pen': 'no label', 'jumlah_kk': 'no label', 'luas_wilay': 'no label', 'kepadatan_': 'no label', 'Shape_Le_1': 'no label', 'Shape_Area': 'no label', });
lyr_Wilayah_Kec_Maluku_1.set('fieldLabels', {'objectid': 'no label', 'kode_siak': 'no label', 'nama_siak': 'no label', 'luas': 'no label', 'objectid_2': 'no label', 'no_prop': 'no label', 'no_kab': 'no label', 'no_kec': 'no label', 'kode_prov_': 'no label', 'kode_kab_s': 'no label', 'kode_kec_s': 'no label', 'nama_prop_': 'no label', 'nama_kab_s': 'no label', 'nama_kec_s': 'no label', 'jumlah_des': 'no label', 'luas_wilay': 'no label', 'Shape_Leng': 'no label', 'Shape_Area': 'no label', });
lyr_Kawasan_Kumuh_MBD_2.set('fieldLabels', {'Kawasan': 'no label', 'Provinsi': 'no label', 'Kode_Prov': 'no label', 'Kab_Kota': 'no label', 'Kode_Kab': 'no label', 'Kecamatan': 'no label', 'Kode_Kec': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Kode_RT_RW': 'no label', 'Luas_Kumuh': 'no label', 'Skor_Kumuh': 'no label', 'Smber_Data': 'no label', });
lyr_KawasanKumuhKota_Tual_3.set('fieldLabels', {'OBJECTID': 'no label', 'Provinsi': 'no label', 'Kode_Prov': 'no label', 'Kab_Kota': 'no label', 'Kode_Kab': 'no label', 'Kecamatan': 'no label', 'Kode_Kec': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'RW': 'no label', 'RT': 'no label', 'Kode_RTRW': 'no label', 'Label': 'no label', 'LUASANBARU': 'no label', 'Kawasan': 'no label', 'Skor_Kumuh': 'no label', 'Kekumuhan': 'no label', 'Smbr_Data': 'no label', });
lyr_KawasanKumuhMalteng_4.set('fieldLabels', {'Id': 'no label', 'Kecamatan': 'no label', 'Desa': 'no label', 'Deliniasi': 'no label', 'Jml_Pendud': 'no label', 'Kepa_datan': 'no label', 'Kekumuhan': 'no label', 'Nilai': 'no label', 'Luas': 'no label', 'X': 'no label', 'Y': 'no label', 'Luasanbaru': 'no label', 'Pembanding': 'no label', });
lyr_KawasanKumuh_Seram_Bagian_Barat_5.set('fieldLabels', {'Id': 'no label', 'Provinsi': 'no label', 'Kode_Prov': 'no label', 'Kab_Kota': 'no label', 'Kode_Kab': 'no label', 'Kecamatan': 'no label', 'Kode_Kec': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Kode_RT_RW': 'no label', 'Luas_Kumuh': 'no label', 'Skor_Kumuh': 'no label', 'Smbr_Data': 'no label', 'X': 'no label', 'Y': 'no label', 'Kawasan': 'no label', });
lyr_KawasanKumuh_Seram_Bagian_Timur_6.set('fieldLabels', {'Id': 'no label', 'Provinsi': 'no label', 'Kode_Prov': 'no label', 'Kab_Kota': 'no label', 'Kode_Kab': 'no label', 'Kecamatan': 'no label', 'Kode_Kec': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Kode_RT_RW': 'no label', 'Luas_Kumuh': 'no label', 'Skor_Kumuh': 'no label', 'Kawasan': 'no label', 'Smbr_Data': 'no label', 'X': 'no label', 'Y': 'no label', });
lyr_Kawasan_Kumuh_Buru_7.set('fieldLabels', {'Id': 'no label', 'Provinsi': 'no label', 'Kode_Prov': 'no label', 'Kab_Kota': 'no label', 'Kode_Kab': 'no label', 'Kecamatan': 'no label', 'Kode_Kec': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Kode_RT_RW': 'no label', 'Luas_Kumuh': 'no label', 'Skor_Kumuh': 'no label', 'Kawasan': 'no label', 'Smber_Data': 'no label', 'X': 'no label', 'Y': 'no label', });
lyr_Kawasan_Kumuh_Buru_Selatan_8.set('fieldLabels', {'Id': 'no label', 'Kawasan': 'no label', 'Provinsi': 'no label', 'Kode_Prov': 'no label', 'Kab_Kota': 'no label', 'Kode_Kab': 'no label', 'Kecamatan': 'no label', 'Kode_Kec': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Kode_RT_RW': 'no label', 'Luas_Kumuh': 'no label', 'Skor_Kumuh': 'no label', 'Smber_Data': 'no label', 'X': 'no label', 'Y': 'no label', });
lyr_KawasanKumuh_Maluku_Tenggara_9.set('fieldLabels', {'NAME': 'no label', 'Provinsi': 'no label', 'Kode_Prov': 'no label', 'Kab_Kota': 'no label', 'Kode_Kab': 'no label', 'Kecamatan': 'no label', 'Kode_Kec': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Kode_RT_RW': 'no label', 'Luas_Kumuh': 'no label', 'Skor_Kumuh': 'no label', 'Smbr_Data': 'no label', 'Kawasan': 'no label', 'Bujur': 'no label', 'Lintang': 'no label', });
lyr_Kawasan_Kumuh_Aru_10.set('fieldLabels', {'Provinsi': 'no label', 'Kode_Prov': 'no label', 'Kab_Kota': 'no label', 'Kode_Kab': 'no label', 'Kecamatan': 'no label', 'Kode_Kec': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Kode_RT_RW': 'no label', 'Luas_Kumuh': 'no label', 'Skor_Kumuh': 'no label', 'Smbr_Data': 'no label', 'X': 'no label', 'Y': 'no label', 'Kawasan': 'no label', });
lyr_KawasanKumuhKotaAmbon_11.set('fieldLabels', {'Prov': 'no label', 'Kode_Prov': 'no label', 'Kab_Kota': 'no label', 'Kode_Kab': 'no label', 'Kecamatan': 'no label', 'Kode_Kec': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Basis': 'no label', 'Sumber': 'no label', 'luasan': 'no label', 'Nama_Kwsan': 'no label', 'LUASANFIX': 'no label', });
lyr_Ridool_12.set('fieldLabels', {'Prov': 'no label', 'Kab_Kota': 'no label', 'Kecamatan': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Basis': 'no label', 'Luas': 'no label', 'Nama_Kawas': 'no label', 'Luasanbaru': 'no label', });
lyr_Ritabel_13.set('fieldLabels', {'Prov': 'no label', 'Kab_Kota': 'no label', 'Kecamatan': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Basis': 'no label', 'Luas': 'no label', 'Nama_Kawas': 'no label', 'Luasanbaru': 'no label', });
lyr_Saumlaki_14.set('fieldLabels', {'Prov': 'no label', 'Kab_Kota': 'no label', 'Kecamatan': 'no label', 'Kelurahan': 'no label', 'Kode_Kel': 'no label', 'Basis': 'no label', 'Luasan': 'no label', 'Nama_Kawas': 'no label', 'Luasan_202': 'no label', });
lyr_MalukuTengah_15.set('fieldLabels', {'No': 'no label', 'Tanggal_Up': 'no label', 'Tanggal_Mo': 'no label', 'Nama_Penda': 'no label', 'Nama_Pener': 'no label', 'Kabupaten_': 'no label', 'Nama_Desa': 'no label', 'Nama_Toko': 'no label', 'Jumlah_Bia': 'no label', 'Presentasi': 'no label', 'Sisa__Rp__': 'no label', 'Jumlah_B_1': 'no label', 'Presenta_1': 'no label', 'Sisa__Rp_1': 'no label', 'Latitude': 'no label', 'Longitude': 'no label', 'Presenta_2': 'no label', 'Photo': 'no label', 'Photo Sebe': 'no label', });
lyr_BuruSelatan_16.set('fieldLabels', {'No': 'no label', 'Tanggal_Up': 'hidden field', 'Tanggal_Mo': 'inline label - visible with data', 'Nama_Penda': 'no label', 'Nama_Pener': 'no label', 'Kabupaten_': 'no label', 'Nama_Desa': 'no label', 'Nama_Toko': 'no label', 'Jumlah_Bia': 'no label', 'Presentasi': 'no label', 'Sisa__Rp__': 'no label', 'Jumlah_B_1': 'no label', 'Presenta_1': 'no label', 'Sisa__Rp_1': 'no label', 'Latitude': 'no label', 'Longitude': 'no label', 'Presenta_2': 'no label', 'F18': 'no label', 'F19': 'no label', 'F20': 'no label', 'F21': 'no label', 'Before': 'no label', });
lyr_Kota_Ambon_17.set('fieldLabels', {'No': 'no label', 'Tanggal_Up': 'inline label - visible with data', 'Latitude': 'no label', 'Longitude': 'no label', 'Tanggal_Mo': 'no label', 'Nama_Penda': 'inline label - always visible', 'Nama_Pener': 'inline label - always visible', 'Kabupaten_': 'inline label - always visible', 'Nama_Desa': 'inline label - always visible', 'Nama_Toko': 'no label', 'Jumlah_Bia': 'no label', 'Presentasi': 'no label', 'Sisa__Rp__': 'no label', 'Jumlah_B_1': 'no label', 'Presenta_1': 'no label', 'Sisa__Rp_1': 'no label', 'Latitude1': 'no label', 'Longitude1': 'no label', 'Presenta_2': 'no label', 'Before': 'no label', 'After': 'no label', 'PHOTO1': 'inline label - always visible', 'PHOTO2': 'inline label - always visible', });
lyr_SeramBagianBarat_18.set('fieldLabels', {'No': 'no label', 'Tanggal_Up': 'no label', 'Tanggal_Mo': 'no label', 'Nama_Penda': 'no label', 'Nama_Pener': 'no label', 'Kabupaten_': 'no label', 'Nama_Desa': 'no label', 'Nama_Toko': 'no label', 'Jumlah_Bia': 'no label', 'Presentasi': 'no label', 'Sisa__Rp__': 'no label', 'Jumlah_B_1': 'no label', 'Presenta_1': 'no label', 'Sisa__Rp_1': 'no label', 'Latitude': 'no label', 'Longitude': 'no label', 'Presenta_2': 'no label', 'F18': 'no label', 'F19': 'no label', 'F20': 'no label', });
lyr_SeramBagianTimur_19.set('fieldLabels', {'No': 'no label', 'Tanggal_Up': 'no label', 'Tanggal_Mo': 'no label', 'Nama_Penda': 'no label', 'Nama_Pener': 'no label', 'Kabupaten_': 'no label', 'Nama_Desa': 'no label', 'Nama_Toko': 'no label', 'Jumlah_Bia': 'no label', 'Presentasi': 'no label', 'Sisa__Rp__': 'no label', 'Jumlah_B_1': 'no label', 'Presenta_1': 'no label', 'Sisa__Rp_1': 'no label', 'Latitude': 'no label', 'Longitude': 'no label', 'Presenta_2': 'no label', });
lyr_SeramBagianTimur_19.on('precompose', function(evt) {
    evt.context.globalCompositeOperation = 'normal';
});