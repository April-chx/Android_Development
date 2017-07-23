package com.example.movie_time;

import android.content.Context;
import android.graphics.Camera;
import android.graphics.Matrix;
import android.util.AttributeSet;
import android.view.View;
import android.view.animation.Transformation;
import android.widget.Gallery;
import android.widget.ImageView;

public class CoverFlow extends Gallery {

	/**
	 * Graphics Camera used for transforming the matrix of ImageViews
	 */
	private Camera mCamera = new Camera();// 相机类

	/**
	 * The maximum angle the Child ImageView will be rotated by
	 */
	private int mMaxRotationAngle = 80;// 最大转动角度

	/**
	 * The maximum zoom on the centre Child
	 */
	// private int mMaxZoom = -120;//最大缩放值

	/**
	 * The Centre of the Coverflow
	 */
	private int mCoveflowCenter;// 半径值

	public CoverFlow(Context context) {
		super(context);
		// 支持转换 ,执行getChildStaticTransformation方法
		this.setStaticTransformationsEnabled(true);
	}

	public CoverFlow(Context context, AttributeSet attrs) {
		super(context, attrs);
		this.setStaticTransformationsEnabled(true);
	}

	public CoverFlow(Context context, AttributeSet attrs, int defStyle) {
		super(context, attrs, defStyle);
		this.setStaticTransformationsEnabled(true);
	}

	/**
	 * Get the max rotational angle of the image
	 * 
	 * @return the mMaxRotationAngle
	 */
	/** * 获取旋转最大角度 * @return */
	public int getMaxRotationAngle() {
		return mMaxRotationAngle;
	}

	/**
	 * Set the max rotational angle of each image
	 * 
	 * @param maxRotationAngle
	 *            the mMaxRotationAngle to set
	 */
	/** * 设置旋转最大角度 * @param maxRotationAngle */
	public void setMaxRotationAngle(int maxRotationAngle) {
		mMaxRotationAngle = maxRotationAngle;
	}

	/**
	 * Get the Max zoom of the centre image
	 * 
	 * @return the mMaxZoom
	 */
	/** * 获取最大缩放值 * @param maxZoom */
	// public int getMaxZoom() {
	// return mMaxZoom;
	// }

	/**
	 * Set the max zoom of the centre image
	 * 
	 * @param maxZoom
	 *            the mMaxZoom to set
	 */
	/** * 设置最大缩放值 * @param maxZoom */
	// public void setMaxZoom(int maxZoom) {
	// mMaxZoom = maxZoom;
	// }

	/**
	 * Get the Centre of the Coverflow
	 * 
	 * @return The centre of this Coverflow.
	 */
	/** * 获取半径值 * @return */
	private int getCenterOfCoverflow() {
		return (getWidth() - getPaddingLeft() - getPaddingRight()) / 2
				+ getPaddingLeft();
	}

	/**
	 * Get the Centre of the View
	 * 
	 * @return The centre of the given view.
	 */
	private static int getCenterOfView(View view) {
		return view.getLeft() + view.getWidth() / 2;
	}

	/**
	 * {@inheritDoc}
	 * 
	 * @see #setStaticTransformationsEnabled(boolean)
	 */
	// 控制gallery中每个图片的旋转(重写的gallery中方法)
	protected boolean getChildStaticTransformation(View child, Transformation t) {

		// 取得当前子view的半径值
		final int childCenter = getCenterOfView(child);
		final int childWidth = child.getWidth();

		// 旋转角度
		int rotationAngle = 0;
		// 重置转换状态
		t.clear();
		// 设置转换类型
		t.setTransformationType(Transformation.TYPE_MATRIX);

		// 如果图片位于中心位置不需要进行旋转
		if (childCenter == mCoveflowCenter) {
			transformImageBitmap((ImageView) child, t, 0);
		} else {
			// 根据图片在gallery中的位置来计算图片的旋转角度
			rotationAngle = (int) (((float) (mCoveflowCenter - childCenter) / childWidth) * mMaxRotationAngle);
			// 如果旋转角度绝对值大于最大旋转角度返回（-mMaxRotationAngle或mMaxRotationAngle;）
			if (Math.abs(rotationAngle) > mMaxRotationAngle) {
				rotationAngle = (rotationAngle < 0) ? -mMaxRotationAngle : mMaxRotationAngle;
			}
			transformImageBitmap((ImageView) child, t, rotationAngle);
		}

		return true;
	}

	/**
	 * This is called during layout when the size of this view has changed. If
	 * you were just added to the view hierarchy, you're called with the old
	 * values of 0.
	 * 
	 * @param w
	 *            Current width of this view.
	 * @param h
	 *            Current height of this view.
	 * @param oldw
	 *            Old width of this view.
	 * @param oldh
	 *            Old height of this view.
	 */
	protected void onSizeChanged(int w, int h, int oldw, int oldh) {
		mCoveflowCenter = getCenterOfCoverflow();
		super.onSizeChanged(w, h, oldw, oldh);
	}

	/**
	 * Transform the Image Bitmap by the Angle passed
	 * 
	 * @param imageView
	 *            ImageView the ImageView whose bitmap we want to rotate
	 * @param t
	 *            transformation
	 * @param rotationAngle
	 *            the Angle by which to rotate the Bitmap
	 */
	private void transformImageBitmap(ImageView child, Transformation t,
			int rotationAngle) {
		// 对效果进行保存
		mCamera.save();
		final Matrix imageMatrix = t.getMatrix();
		// 图片高度
		final int imageHeight = child.getLayoutParams().height;
		// 图片宽度
		final int imageWidth = child.getLayoutParams().width;
		// 返回旋转角度的绝对值
		final int rotation = Math.abs(rotationAngle);

		// 在Z轴上正向移动camera的视角，实际效果为放大图片。
		// 如果在Y轴上移动，则图片上下移动；X轴上对应图片左右移动。
		mCamera.translate(0.0f, 0.0f, 100.0f);

		// As the angle of the view gets less, zoom in
		if (rotation < mMaxRotationAngle) {
			float zoomAmount = (float) (rotation * 1.5);
			mCamera.translate(0.0f, 0.0f, zoomAmount);
		}

		// 在Y轴上旋转，对应图片竖向向里翻转。
		// 如果在X轴上旋转，则对应图片横向向里翻转。
		mCamera.rotateY(rotationAngle);
		mCamera.getMatrix(imageMatrix);
		imageMatrix.preTranslate(-(imageWidth / 2), -(imageHeight / 2));
		imageMatrix.postTranslate((imageWidth / 2), (imageHeight / 2));
		mCamera.restore();
	}
}
