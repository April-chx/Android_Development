package com.example.movie_time;

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.List;

import android.content.Context;
import android.content.res.AssetManager;
import android.content.res.TypedArray;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Gallery;
import android.widget.ImageView;
import android.widget.TextView;

public class Main_Interface_Adapter extends BaseAdapter {
	
	int mGalleryItemBackground;
	private List<String> imageUrls; // ͼƬ��ַlist
	private Context context;

	public Main_Interface_Adapter(List<String> imageUrls, Context context) {
		this.imageUrls = imageUrls;
		this.context = context;
		// /*
		// * ʹ����res/values/attrs.xml�е�<declare-styleable>���� ��Gallery����.
		// */
		TypedArray a = context.obtainStyledAttributes(R.styleable.Gallery1);
		/* ȡ��Gallery���Ե�Index id */
		mGalleryItemBackground = a.getResourceId(
				R.styleable.Gallery1_android_galleryItemBackground, 0);
		/* �ö����styleable�����ܹ�����ʹ�� */
		a.recycle();
	}

	public int getCount() {
		return imageUrls.size();
	}

	public Object getItem(int position) {
		return position;
	}

	public long getItemId(int position) {
		return position;
	}

	public View getView(int position, View convertView, ViewGroup parent) {

		ImageView view = new ImageView(context);

		// ��������ͼƬ����Դ��ַ
		view.setImageBitmap(returnBitMap(imageUrls.get(position)));
		view.setScaleType(ImageView.ScaleType.CENTER_INSIDE);
		view.setLayoutParams(new CoverFlow.LayoutParams(250, 345));
		view.setBackgroundResource(mGalleryItemBackground);

		return view;
	}
	
	public Bitmap returnBitMap(String url){ 
        URL myFileUrl = null;   
        Bitmap bitmap = null;  
        try {   
            myFileUrl = new URL(url);   
        } catch (MalformedURLException e) {   
            e.printStackTrace();   
        }   
        try {   
            HttpURLConnection conn = (HttpURLConnection) myFileUrl   
              .openConnection();   
            conn.setDoInput(true);   
            conn.connect();   
            InputStream is = conn.getInputStream();   
            bitmap = BitmapFactory.decodeStream(is);   
            is.close();   
        } catch (IOException e) {   
              e.printStackTrace();   
        }   
              return bitmap;   
    }
}