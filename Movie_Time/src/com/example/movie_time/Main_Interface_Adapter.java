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
	private List<String> imageUrls; // 图片地址list
	private Context context;

	public Main_Interface_Adapter(List<String> imageUrls, Context context) {
		this.imageUrls = imageUrls;
		this.context = context;
		// /*
		// * 使用在res/values/attrs.xml中的<declare-styleable>定义 的Gallery属性.
		// */
		TypedArray a = context.obtainStyledAttributes(R.styleable.Gallery1);
		/* 取得Gallery属性的Index id */
		mGalleryItemBackground = a.getResourceId(
				R.styleable.Gallery1_android_galleryItemBackground, 0);
		/* 让对象的styleable属性能够反复使用 */
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

		// 设置所有图片的资源地址
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